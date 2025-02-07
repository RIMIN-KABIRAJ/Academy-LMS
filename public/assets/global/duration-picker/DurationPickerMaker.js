// Version 1.0


class DurationPickerMaker {

    TIME_CHUNK_SELECTION_ATTR_NAME = "time-chunk-selection-mode";

    _SelectTextInTargetElement(event) {
        let selectedTimeChunkName = this._formattedDuration.GetSelectedTimeChunk(event.target.selectionStart);
        let selectionRange = this._formattedDuration.GetIndexRangeForTimeChunk(selectedTimeChunkName);
        event.target.setAttribute(this.TIME_CHUNK_SELECTION_ATTR_NAME, selectedTimeChunkName);
        event.target.setSelectionRange(selectionRange.startIndex, selectionRange.endIndex);
    };

    _HighlightArea(inputBox, range) {
        inputBox.focus();
        inputBox.select();
        inputBox.selectionStart = range.startIndex;
        inputBox.endIndex = range.endIndex;
    }

    _SetValueAndNotifyObservers()
    {
        this._targetElement.value = this._formattedDuration.ToFormattedString();
        this._NotifySecondValueObservers(this._formattedDuration.ToTotalSeconds());
    }
    IncrementSeconds()
    {
        this._formattedDuration.AddSeconds(1);
        this._SetValueAndNotifyObservers();
    }

    _GetCursorPosition()
    {
        let field = this._targetElement;
        if (field.selectionStart || field.selectionStart === '0' || field.selectionStart === 0)
        {
            return field.selectionDirection==='backward' ? field.selectionStart : field.selectionEnd;
        }
        return null;
    }

    ResetSeconds(){
        this._formattedDuration.SetTotalSeconds(0);
        this._SetValueAndNotifyObservers();
    }

    _ChangeValueDueToUpOrDownArrowKeyPressed(targetElement, direction) {
        const selectedChunkName = targetElement.getAttribute(this.TIME_CHUNK_SELECTION_ATTR_NAME);
        if (direction === "up") {
            this._formattedDuration.IncrementValueForTimeChunk(selectedChunkName);
        } else if (direction === 'down') {
            this._formattedDuration.DecrementValueTimeChunk(selectedChunkName);
        }
        this._SetValueAndNotifyObservers();
        this._HighlightArea(targetElement, this._formattedDuration.GetIndexRangeForTimeChunk(selectedChunkName));
    };

    _ShiftFocusLeft(inputBox) {
        let chunkName = inputBox.getAttribute(this.TIME_CHUNK_SELECTION_ATTR_NAME);
        this._SetValueAndNotifyObservers();
        if (chunkName === this._formattedDuration.HOURS_CHUNK || chunkName === this._formattedDuration.MINUTES_CHUNK) {
            this._HighlightArea(inputBox, this._formattedDuration.GetIndexRangeForHoursChunk());
            return;
        }
        this._HighlightArea(inputBox, this._formattedDuration.GetIndexRangeForMinutesChunk());
    }

    _ShiftFocusRight(targetElement) {
        let chunkName = targetElement.getAttribute(this.TIME_CHUNK_SELECTION_ATTR_NAME);
        this._SetValueAndNotifyObservers();
        if (chunkName === this._formattedDuration.SECONDS_CHUNK || chunkName === this._formattedDuration.MINUTES_CHUNK) {
            this._HighlightArea(targetElement, this._formattedDuration.GetIndexRangeForSecondsChunk());// select hours area as it was selectee
            return;
        }
        this._HighlightArea(targetElement, this._formattedDuration.GetIndexRangeForMinutesChunk())
    }

    _SetFormattedStringFromTargetIfValid(event) {
        let currentValue = event.target.value;
        if (this._formattedDuration.IsFormattedStringValid(currentValue)) {
            this._formattedDuration.FromFormattedString(currentValue);
        }
    };

    _SetValueFromFormattedStringButDontLooseSelection(){
        let previousCursorPos = this._GetCursorPosition();
        if( previousCursorPos !== null)
        {
            let selectedChunkName = this._formattedDuration.GetSelectedTimeChunk(previousCursorPos);
            this._SetValueAndNotifyObservers();
            this._HighlightArea(this._targetElement, this._formattedDuration.GetIndexRangeForTimeChunk(selectedChunkName));
        }
        else
        {
            // "could not set value, previousCursorPos is null"
        }
    }

    _HandleKeyDown(event) {
        if (event.key === 'ArrowDown' || event.key === 'ArrowUp' || event.key === 'ArrowLeft' || event.key === 'ArrowRight') {
            switch (event.key) {
                // use up and down arrow keys to increase value;
                case 'ArrowDown':
                    this._ChangeValueDueToUpOrDownArrowKeyPressed(event.target, 'down');
                    break;
                case 'ArrowUp':
                    this._ChangeValueDueToUpOrDownArrowKeyPressed(event.target, 'up');
                    break;
                // use left and right arrow keys to shift focus;
                case 'ArrowLeft':
                    this._ShiftFocusLeft(event.target);
                    break;
                case 'ArrowRight':
                    this._ShiftFocusRight(event.target);
                    break;
            }
            event.preventDefault();
        }
        // The following keys will be accepted when the input field is selected
        const acceptedKeys = ['Backspace', 'ArrowDown', 'ArrowUp', 'Tab'];
        if (isNaN(event.key) && !acceptedKeys.includes(event.key)) {
            event.preventDefault();
        }
    };

    constructor(formattedDuration) {
        this._formattedDuration = formattedDuration;
        this._secondValueObservers = [];
        this._targetElement = null;
    }

    SetPickerElement(targetElement) {
        // todo: add validation when target element is null or does not have some properties (e.g. value)
        if (targetElement.getAttribute('data-upgraded') === 'true') {
            return; // in case some developer calls this or includes it twice
        }
        this._targetElement = targetElement;
        targetElement.setAttribute('data-upgraded', true);
        targetElement.value = this._formattedDuration.ToFormattedString();
        this._ConnectEvents(targetElement);
        this._NotifySecondValueObservers(this._formattedDuration.ToTotalSeconds());
    }

    _NotifySecondValueObservers(newValue) {
        this._secondValueObservers.forEach(function (item, index, array) {
            // assuming that observer has method: setSecondsValue([int])
            item.setSecondsValue(newValue)
        })
    }

    AddSecondChangeObserver(secondChangeObservers) {
        this._secondValueObservers.push(secondChangeObservers);
        this._NotifySecondValueObservers(this._formattedDuration.ToTotalSeconds());
    }

    _OnKeyUpHandler(event) {
        this._SetFormattedStringFromTargetIfValid(event );
        this._NotifySecondValueObservers(this._formattedDuration.ToTotalSeconds());
    }

    _OnKeyDownHandler(event) {
        this._HandleKeyDown(event);
    }

    _OnSelectHandler(event) {
        this._SelectTextInTargetElement(event);
    }

    _OnMouseUpHandler(event) {
        this._SelectTextInTargetElement(event);
        this._SetValueFromFormattedStringButDontLooseSelection();
    }

    _OnChangeHandler(event) {
    }

    _OnBlurHandler(event) {
        this._SetFormattedStringFromTargetIfValid(event);
        this._SetValueAndNotifyObservers();
    }

    _ConnectEvents(pickerElement) {
        pickerElement.addEventListener('keydown', (event) => this._OnKeyDownHandler(event));
        pickerElement.addEventListener('select', (event) => this._OnSelectHandler(event));
        pickerElement.addEventListener('mouseup', (event) => this._OnMouseUpHandler(event));
        pickerElement.addEventListener('change', (event) => this._OnChangeHandler(event));
        pickerElement.addEventListener('blur', (event) => this._OnBlurHandler(event));
        pickerElement.addEventListener('keyup', (event) => this._OnKeyUpHandler(event));
        pickerElement.addEventListener('drop', (event) => event.preventDefault());
    }
}



class FormattedDuration {

    DEFAULT_HOURS_UNIT = ":";
    DEFAULT_MINUTES_UNIT = ":";
    DEFAULT_SECONDS_UNIT = "";

    SECONDS_IN_HOUR = 3600;
    SECONDS_IN_MINUTE = 60;
    ONE_SECOND = 1;


    constructor(config = {
        hoursUnitString: ":",
        minutesUnitString: ":",
        secondsUnitString: ""
    }) {
        this.SECONDS_CHUNK = "seconds";
        this.MINUTES_CHUNK = "minutes";
        this.HOURS_CHUNK = "hours";
        this.CHUNK_OUT_OF_RANGE = "OutOfRange";

        this._hoursUnit = this.DEFAULT_HOURS_UNIT;
        this._minutesUnit = this.DEFAULT_MINUTES_UNIT;
        this._secondsUnit = this.DEFAULT_SECONDS_UNIT;

        if (config.hasOwnProperty("hoursUnitString")) {
            this._hoursUnit = config.hoursUnitString;
        }

        if (config.hasOwnProperty("minutesUnitString")) {
            this._minutesUnit = config.minutesUnitString;
        }

        if (config.hasOwnProperty("secondsUnitString")) {
            this._secondsUnit = config.secondsUnitString;
        }

        this._ValidateInternalStateOrThrow();
        this._seconds = 0;
        this._minutes = 0;
        this._hours = 0;
        this._totalSeconds = 0;
    }

    _ValidateInternalStateOrThrow() {

        var hourRegex = new RegExp("^\\D(.*\\D)?$", "g");
        var minuteRegex = new RegExp("^\\D(.*\\D)?$", "g");

        if (this._hoursUnit.length === 0) {
            throw new Error("hour unit cannot be empty");
        }

        if (this._minutesUnit.length === 0) {
            throw new Error("minute unit cannot be empty");
        }

        if (!hourRegex.test(this._hoursUnit)) {
            throw new Error("invalid hour unit '" + this._hoursUnit + "'");
        }

        if (!minuteRegex.test(this._minutesUnit)) {
            throw new Error("invalid minute unit '" + this._minutesUnit + "'");
        }
    }

    _FormattedHours() {
        return ("" + this._hours).padStart(2, "0");
    }

    _FormattedMinutes() {
        return ("" + this._minutes).padStart(2, "0");
    }

    _FormattedSeconds() {
        return ("" + this._seconds).padStart(2, "0")
    }

    _FormattedHoursWithUnit() {
        return this._FormattedHours() + this._hoursUnit;
    }

    _FormattedMinutesWithUnit() {
        return this._FormattedMinutes() + this._minutesUnit;
    }

    _FormattedSecondsWithUnit() {
        return this._FormattedSeconds() + this._secondsUnit;
    }

    _GetIntegerOrNan(value) {
        if (typeof value === 'string' && value.length === 0) {
            return NaN;
        }
        let n = Number(value);
        if (isNaN(n)) {
            return NaN;
        }
        if (Number.isInteger(n)) {
            return n;
        }
        return NaN;
    }

    ToFormattedString() {

        return this._FormattedHoursWithUnit() +
            this._FormattedMinutesWithUnit() +
            this._FormattedSecondsWithUnit();
    }

    ToTotalSeconds() {
        return this._totalSeconds;
    }

    AddSeconds(seconds) {
        this.SetTotalSeconds(this._totalSeconds + seconds);
    }

    SubtractSeconds(seconds) {
        let intSeconds = this._GetIntegerOrNan(seconds);
        if(isNaN(intSeconds) || intSeconds < 0){
            return;
        }

        if (this._totalSeconds - intSeconds < 0) {
            return;
        }
        this._totalSeconds -= intSeconds;
        this._ResetFromTotalSeconds();
    }

    SetTotalSeconds(seconds) {
        // todo: what is max value ?
        let intSeconds = this._GetIntegerOrNan(seconds);
        if(isNaN(intSeconds) || intSeconds < 0){
            return;
        }

        // todo , validate input
        // value must be int and not negative
        // and not bigger then .. figure out max value
        this._totalSeconds = seconds;
        this._ResetFromTotalSeconds()
    }

    _ResetFromTotalSeconds() {
        this._hours = Math.floor(this._totalSeconds / this.SECONDS_IN_HOUR);
        this._minutes = Math.floor((this._totalSeconds % this.SECONDS_IN_HOUR) / this.SECONDS_IN_MINUTE);
        this._seconds = Math.floor((this._totalSeconds % this.SECONDS_IN_HOUR) % this.SECONDS_IN_MINUTE);
    }

    _RecalculateTotalSeconds(hours, minutes, seconds) {
        if (Number.isInteger(hours)) {
            this._hours = hours;
        }

        if (Number.isInteger(minutes)) {
            this._minutes = minutes;
        }

        if (Number.isInteger(seconds)) {
            this._seconds = seconds;
        }

        this._totalSeconds = this._hours * this.SECONDS_IN_HOUR +
            this._minutes * this.SECONDS_IN_MINUTE +
            this._seconds;

        //console.log(`Realculated to ${this._hours}:${this._minutes}:${this._seconds}`);
    }

    FromFormattedString(formattedString) {
        // todo: validate if value is not a string
        // cut the string into pieces
        // and extract each value from it
        let spitedChunks = this._ExtractTimeValuesFromFormattedString(formattedString);
        let [hours, minutes, seconds] = spitedChunks;
        this._RecalculateTotalSeconds(hours, minutes, seconds);
    }



    // always return table with thre
    _ExtractTimeValuesFromFormattedString(formattedString) {
        const hoursUnitStringIndex = formattedString.indexOf(this._hoursUnit);
        if (hoursUnitStringIndex < 0) {
            return [NaN, NaN, NaN];
        }
        const hoursAsString = formattedString.substring(0, hoursUnitStringIndex);
        const hoursInt = this._GetIntegerOrNan(hoursAsString);

        let minutesTextStartIndex = hoursUnitStringIndex + this._hoursUnit.length;
        const minuteUnitStringIndex = formattedString.indexOf(this._minutesUnit, minutesTextStartIndex);

        if (minuteUnitStringIndex < 0) {
            return [hoursInt, NaN, NaN];
        }
        const minuteAsString = formattedString.substring(minutesTextStartIndex, minuteUnitStringIndex);

        const minutesInt = this._GetIntegerOrNan(minuteAsString);


        let secondsTextStartIndex =  minuteUnitStringIndex + this._minutesUnit.length;

        let secondsAsString = "";
        if(this._secondsUnit.length !== 0 ) // seconds unit can be empty
        {
            const secondUnitStringIndex = formattedString.indexOf(this._secondsUnit, secondsTextStartIndex);
            secondsAsString = formattedString.substring(secondsTextStartIndex,secondUnitStringIndex);
        }
        else{
            secondsAsString = formattedString.substring(secondsTextStartIndex, formattedString.length);
        }

        const secondsInt = this._GetIntegerOrNan(secondsAsString);
        return [hoursInt, minutesInt, secondsInt];
    }

    IsFormattedStringValid(formattedString){
        let resultArray = this._ExtractTimeValuesFromFormattedString(formattedString);
        let isAllValusNonNaNs =  resultArray.every((item)=>{
            return !isNaN(item);
        });
        if(! isAllValusNonNaNs )
        {
            return false;
        }

        let hours = resultArray[0];
        let minutes = resultArray[1];
        let seconds = resultArray[2];
        return hours >= 0 && minutes < 60 && minutes >= 0 && seconds < 60 && seconds >= 0;

    }

    GetSelectedTimeChunk(position) {
        // todo validate if position is not an int
        if (position < 0) {
            return this.CHUNK_OUT_OF_RANGE
        }

        let hourChunkPositionStart = 0;
        let hourChunkLength = this._FormattedHoursWithUnit().length;
        let hourChunkPositionEnd = hourChunkPositionStart + hourChunkLength - 1;


        if ((position >= hourChunkPositionStart) && (position <= hourChunkPositionEnd)) {
            return this.HOURS_CHUNK;
        }

        let minuteChunkPositionStart = hourChunkPositionEnd + 1;
        let minuteChunkLength = this._FormattedMinutesWithUnit().length;
        let minuteChunkPositionEnd = minuteChunkPositionStart + minuteChunkLength - 1;

        if ((position >= minuteChunkPositionStart) && (position <= minuteChunkPositionEnd)) {
            return this.MINUTES_CHUNK;
        }

        let secondChunkPositionStart = minuteChunkPositionEnd + 1;
        let secondChunkLength = this._FormattedSecondsWithUnit().length;
        let secondChunkPositionEnd = secondChunkPositionStart + secondChunkLength - 1;

        if ((position >= secondChunkPositionStart) && (position <= secondChunkPositionEnd + 1)) {
            return this.SECONDS_CHUNK;
        }

        return this.CHUNK_OUT_OF_RANGE;
    }

    // returns object with startIndex,endIndex
    // return -1, -1 if not recognized type
    GetIndexRangeForTimeChunk(chunkName) {

        // todo should throw if chunkName is not known
        let hourChunkEndIndex = this._FormattedHours().length;
        if (chunkName === this.HOURS_CHUNK) {
            return {startIndex: 0, endIndex: hourChunkEndIndex}
        }

        let minuteChunkStartIndex = hourChunkEndIndex + this._hoursUnit.length;
        let minuteChunkEndIndex = minuteChunkStartIndex + this._FormattedMinutes().length;
        if (chunkName === this.MINUTES_CHUNK) {
            return {startIndex: minuteChunkStartIndex, endIndex: minuteChunkEndIndex}
        }

        let secondChunkStartIndex = minuteChunkEndIndex + this._minutesUnit.length;
        let secondsChunkEndIndex = secondChunkStartIndex + this._FormattedSeconds().length;
        if (chunkName === this.SECONDS_CHUNK) {
            return {startIndex: secondChunkStartIndex, endIndex: secondsChunkEndIndex}
        }
    }


    GetIndexRangeForSecondsChunk() {
        return this.GetIndexRangeForTimeChunk(this.SECONDS_CHUNK);
    }

    GetIndexRangeForMinutesChunk() {
        return this.GetIndexRangeForTimeChunk(this.MINUTES_CHUNK);
    }

    GetIndexRangeForHoursChunk() {
        return this.GetIndexRangeForTimeChunk(this.HOURS_CHUNK);
    }

    IncrementValueForTimeChunk(chunkName) {
        if (chunkName === this.HOURS_CHUNK) {
            this.AddSeconds(this.SECONDS_IN_HOUR);
        } else if (chunkName === this.MINUTES_CHUNK) {
            this.AddSeconds(this.SECONDS_IN_MINUTE);
        } else if (chunkName === this.SECONDS_CHUNK) {
            this.AddSeconds(this.ONE_SECOND);
        }
    }

    DecrementValueTimeChunk(chunkName) {
        if (chunkName === this.HOURS_CHUNK) {
            this.SubtractSeconds(this.SECONDS_IN_HOUR);
        }
        else if(chunkName === this.MINUTES_CHUNK)
        {
            this.SubtractSeconds(this.SECONDS_IN_MINUTE);
        }
        else if(chunkName === this.SECONDS_CHUNK)
        {
            this.SubtractSeconds(this.ONE_SECOND);
        }
    }

    // todo: bug:  when user sets e.g. 345 seconds in the input element and then pushes ArrowLeft key, the value stays
    // todo bug: when user sets e.g. 345 seconds and then pushes key up, some strange value appears

}


function initializeDurationPickers(fields) {
    fields.forEach(field => {
        let pickerElement = document.querySelector(field);
        if (pickerElement) {
            let formattedDuration = new FormattedDuration({
                hoursUnitString: " h ",
                minutesUnitString: " m ",
                secondsUnitString: " s ",
            });

            let durationPickerMaker = new DurationPickerMaker(formattedDuration);
            durationPickerMaker.SetPickerElement(pickerElement, window, document);
        } else {
            console.error(`Element with id "${field}" not found.`);
        }
    });
}
function initializeDurationPickers(fields) {
    fields.forEach(field => {
        let pickerElement = document.querySelector(field);
        if (pickerElement) {
            let formattedDuration = new FormattedDuration({
                hoursUnitString: ":",
                minutesUnitString: ":",
                secondsUnitString: "",
            });

            // Read default-seconds attribute and set the default duration
            let defaultSeconds = parseInt(pickerElement.getAttribute('default-seconds'), 10);
            if (!isNaN(defaultSeconds)) {
                formattedDuration.SetTotalSeconds(defaultSeconds);
            }

            let durationPickerMaker = new DurationPickerMaker(formattedDuration);
            durationPickerMaker.SetPickerElement(pickerElement, window, document);
        } else {
            console.error(`Element with id "${field}" not found.`);
        }
    });
}