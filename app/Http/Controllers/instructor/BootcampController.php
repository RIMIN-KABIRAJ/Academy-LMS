<?php

namespace App\Http\Controllers\instructor;

use App\Http\Controllers\Controller;
use App\Models\Bootcamp;
use App\Models\BootcampCategory;
use App\Models\BootcampModule;
use App\Models\BootcampPurchase;
use App\Models\FileUploader;
use App\Models\SeoField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BootcampController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Dhaka');
    }
    public function index()
    {
        $query = Bootcamp::join('bootcamp_categories', 'bootcamps.category_id', 'bootcamp_categories.id')
            ->select('bootcamps.*', 'bootcamp_categories.title as category', 'bootcamp_categories.slug as category_slug')
            ->where('bootcamps.user_id', auth()->user()->id);

        if (request()->has('search')) {
            $query = $query->where('bootcamps.title', 'LIKE', "%" . request()->query('search') . "%");
        }

        if (request()->has('category') && request()->query('category') != 'all') {
            $category = BootcampCategory::where('slug', request()->query('category'))->first();
            $query    = $query->where('bootcamps.category_id', $category->id);
        }

        if (request()->has('status') && request()->query('status') != 'all') {
            $status = request()->query('status') == 'active' ? 1 : 0;
            $query  = $query->where('bootcamps.status', $status);
        }

        if (request()->has('instructor') && request()->query('instructor') != 'all') {
            $query = $query->where('bootcamps.user_id', request()->query('instructor'));
        }

        if (request()->has('price') && request()->query('price') != 'all') {
            $price = request()->query('price');
            $value = 1;
            if ($price == 'free') {
                $column = 'is_paid';
                $value  = 0;
            } elseif ($price == 'discounted') {
                $column = 'discount_flag';
            } elseif ($price == 'paid') {
                $column = 'is_paid';
            }
            $query = $query->where('bootcamps.' . $column, $value);
        }
        $page_data['bootcamps'] = $query->paginate(20)->appends(request()->query());
        return view('instructor.bootcamp.index', $page_data);
    }

    public function create()
    {
        return view('instructor.bootcamp.create');
    }

    public function edit($id)
    {
        $bootcamp = Bootcamp::where('id', $id)->where('user_id', auth()->user()->id)->first();
        if (! $bootcamp) {
            Session::flash('success', get_phrase('Data not found.'));
            return redirect()->route('instructor.bootcamps');
        }

        $page_data['bootcamp_details'] = $bootcamp;
        $page_data['modules']          = BootcampModule::where('bootcamp_id', $id)->get();
        return view('instructor.bootcamp.edit', $page_data);
    }

    public function store(Request $request)
    {
        $rules = [
            'title'            => 'required|string',
            'description'      => 'required|string',
            'category_id'      => 'required',
            'thumbnail'        => 'required|file',
            'is_paid'          => Rule::in(['0', '1']),
            'price'            => 'required_if:is_paid,1|min:1|nullable|numeric',
            'discount_flag'    => Rule::in(['', '1']),
            'discounted_price' => 'required_if:discount_flag,1|min:1|nullable|numeric',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $title = Bootcamp::where('user_id', auth()->user()->id)->where('title', $request->title)->first();
        if ($title) {
            Session::flash('error', get_phrase('This title has been taken.'));
            return redirect()->back();
        }

        $data['user_id']           = auth()->user()->id;
        $data['title']             = $request->title;
        $data['slug']              = slugify($request->title);
        $data['short_description'] = $request->short_description;
        $data['description']       = $request->description;
        $data['publish_date']      = strtotime($request->publish_date);
        $data['category_id']       = $request->category_id;
        $data['is_paid']           = $request->is_paid;
        $data['price']             = $request->price;
        $data['discount_flag']     = $request->discount_flag;
        $data['discounted_price']  = $request->discounted_price;
        $data['status']            = 1;

        if ($request->thumbnail) {
            $data['thumbnail'] = "uploads/bootcamp/thumbnail/" . nice_file_name($request->title, $request->thumbnail->extension());
            FileUploader::upload($request->thumbnail, $data['thumbnail']);
        }

        $insert_id = Bootcamp::insertGetId($data);

        Session::flash('success', get_phrase('Bootcamp has been created.'));
        return redirect()->route('instructor.bootcamp.edit', [$insert_id, 'tab' => 'curriculum']);
    }

    public function delete($id)
    {
        $bootcamp = Bootcamp::where('id', $id)->where('user_id', auth()->user()->id);
        if ($bootcamp->doesntExist()) {
            Session::flash('success', get_phrase('Data not found.'));
            return redirect()->back();
        }

        $bootcamp->delete();
        Session::flash('success', get_phrase('Bootcamp has been deleted.'));
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $query = Bootcamp::where('id', $id)->where('user_id', auth()->user()->id);

        if ($query->doesntExist() || $request->tab == '') {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        $rules = $data = [];
        if ($request->tab == 'basic') {
            $rules = [
                'title'       => 'required|string',
                'description' => 'required|string',
                'category_id' => 'required',
            ];

            $data['title']             = $request->title;
            $data['slug']              = slugify($request->title);
            $data['short_description'] = $request->short_description;
            $data['description']       = $request->description;
            $data['publish_date']      = strtotime($request->publish_date);
            $data['category_id']       = $request->category_id;

            $title = Bootcamp::where('user_id', auth()->user()->id)
                ->where('id', '!=', $id)
                ->where('title', $request->title)->first();
            if ($title) {
                Session::flash('error', get_phrase('This title has been taken.'));
                return redirect()->back();
            }

        } elseif ($request->tab == 'pricing') {
            $rules = [
                'is_paid'          => Rule::in(['0', '1']),
                'price'            => 'required_if:is_paid,1|min:1|nullable|numeric',
                'discount_flag'    => Rule::in(['', '1']),
                'discounted_price' => 'required_if:discount_flag,1|min:1|nullable|numeric',
            ];

            $data['is_paid']          = $request->is_paid;
            $data['price']            = $request->price;
            $data['discount_flag']    = $request->discount_flag;
            $data['discounted_price'] = $request->discounted_price;

        } elseif ($request->tab == 'info') {
            $rules = [
                'requirements' => 'array',
                'outcomes'     => 'array',
                'faqs'         => 'array',
            ];

            //Remove empty value by using array filter function
            $data['requirements'] = json_encode(array_filter($request->requirements, fn($value) => ! is_null($value) && $value !== ''));
            $data['outcomes']     = json_encode(array_filter($request->outcomes, fn($value) => ! is_null($value) && $value !== ''));

            $faqs = [];
            foreach ($request->faq_title as $key => $title) {
                if ($title != '') {
                    $faqs[] = ['title' => $title, 'description' => $request->faq_description[$key]];
                }
            }
            $data['faqs'] = json_encode($faqs);
        } elseif ($request->tab == 'media') {
            if ($request->thumbnail) {
                $data['thumbnail'] = "uploads/bootcamp/thumbnail/" . nice_file_name($request->title, $request->thumbnail->extension());
                FileUploader::upload($request->thumbnail, $data['thumbnail']);
                remove_file($query->first()->thumbnail);
            }

        } elseif ($request->tab == 'seo') {
            $bootcamp_details = $query->first();
            $SeoField         = SeoField::where('name_route', 'bootcamp.details')->where('bootcamp_id', $bootcamp_details->id)->first();

            $seo_data['course_id']        = $id;
            $seo_data['route']            = 'Course Details';
            $seo_data['name_route']       = 'course.details';
            $seo_data['meta_title']       = $request->meta_title;
            $seo_data['meta_description'] = $request->meta_description;
            $seo_data['meta_robot']       = $request->meta_robot;
            $seo_data['canonical_url']    = $request->canonical_url;
            $seo_data['custom_url']       = $request->custom_url;
            $seo_data['json_ld']          = $request->json_ld;
            $seo_data['og_title']         = $request->og_title;
            $seo_data['og_description']   = $request->og_description;
            $seo_data['created_at']       = date('Y-m-d H:i:s');
            $seo_data['updated_at']       = date('Y-m-d H:i:s');

            $meta_keywords_arr = json_decode($request->meta_keywords, true);
            $meta_keywords     = '';
            if (is_array($meta_keywords_arr)) {
                foreach ($meta_keywords_arr as $arr_key => $arr_val) {
                    $meta_keywords .= $meta_keywords == '' ? $arr_val['value'] : ', ' . $arr_val['value'];
                }
                $seo_data['meta_keywords'] = $meta_keywords;
            }

            if ($request->og_image) {
                $originalFileName = $bootcamp_details->id . '-' . $request->og_image->getClientOriginalName();
                $destinationPath  = 'uploads/seo-og-images/' . $originalFileName;
                // Move the file to the destination path
                FileUploader::upload($request->og_image, $destinationPath, 600);
                $seo_data['og_image'] = $destinationPath;
            }

            if ($SeoField) {
                if ($request->og_image) {
                    remove_file($SeoField->og_image);
                }
                SeoField::where('name_route', 'course.details')->where('course_id', $bootcamp_details->id)->update($seo_data);
            } else {
                SeoField::insert($seo_data);
            }
        }

        //For ajax form submission
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $query->update($data);

        //For ajax form submission
        // return ['success' => get_phrase('Course updated successfully')];

        //for normal form submission
        Session::flash('success', get_phrase('Bootcamp has been updated successfully.'));
        return redirect()->back();
    }

    public function duplicate($id)
    {
        $bootcamp = Bootcamp::where('id', $id);
        if ($bootcamp->doesntExist()) {
            Session::flash('success', get_phrase('Data not found.'));
            return redirect()->back();
        }

        $bootcamp            = $bootcamp->first()->toArray();
        $bootcamp['title']   = $bootcamp['title'] . ' copy';
        $bootcamp['slug']    = slugify($bootcamp['title']);
        $bootcamp['user_id'] = auth()->user()->id;
        $bootcamp['status']  = 1;
        unset($bootcamp['id'], $bootcamp['created_at'], $bootcamp['updated_at']);

        $insert_id = Bootcamp::insertGetId($bootcamp);

        Session::flash('success', get_phrase('Bootcamp has been duplicated.'));
        return redirect()->route('instructor.bootcamp.edit', [$insert_id, 'tab' => 'basic']);
    }

    public function status($id)
    {
        $bootcamp = Bootcamp::where('id', $id)->where('user_id', auth()->user()->id);
        if ($bootcamp->doesntExist()) {
            $response = [
                'error' => get_phrase('Data not found.'),
            ];
            return json_encode($response);
        }

        $status = $bootcamp->first()->status ? 0 : 1;
        Bootcamp::where('id', $id)->update(['status' => $status]);

        $response = [
            'success' => get_phrase('Status has been updated.'),
        ];
        return json_encode($response);
    }

    public function purchase_history()
    {
        $page_data['purchases'] = BootcampPurchase::join('bootcamps', 'bootcamp_purchases.bootcamp_id', 'bootcamps.id')
            ->where('bootcamps.user_id', auth()->user()->id)
            ->select(
                'bootcamp_purchases.*',
                'bootcamps.user_id as author',
                'bootcamps.title',
                'bootcamps.slug',
                'bootcamps.price as amount',
            )
            ->latest('bootcamp_purchases.id')->paginate(20)->appends(request()->query());

        return view('instructor.bootcamp.purchase_history', $page_data);
    }

    public function invoice($id)
    {
        $invoice = BootcampPurchase::join('bootcamps', 'bootcamp_purchases.bootcamp_id', 'bootcamps.id')
            ->where('bootcamps.user_id', auth()->user()->id)
            ->where('bootcamp_purchases.id', $id)
            ->select(
                'bootcamp_purchases.*',
                'bootcamps.title',
                'bootcamps.slug',
            )->first();

        if (! $invoice) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        $page_data['invoice'] = $invoice;
        return view('instructor.bootcamp.invoice', $page_data);
    }
}
