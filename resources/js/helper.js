function dateFormatReturn(date) {
    date = date.split(' ');

    let dateArr = date[0].split('-');
    let timeArr = date[1].split(':');
    const format = new Date(dateArr[0], dateArr[1] - 1, dateArr[2], timeArr[0], timeArr[1], 0);

    return format;
}

export const Helper = {
    urlFormat(url) {
        return `${env.APP_URL}${url}`;
    },
    getUrlSearch(param) {
        const params = {};
        document.location.search.substr(1).split('&').forEach(pair => {
            const [key, value] = pair.split('=');
            params[key] = value;
        });

        return decodeURI(params[param]);
    },
    nullCheck(value) {
        return value == '' || value == null || value == undefined || value == 'undefined';
    },
    thumbnail(file) {
        let path;

        if (Object.keys(file).length === 0) {
            path = this.urlFormat('/images/global/default_thumbnail.png');
        } else {
            path = file.url;
        }

        return path;
    },
    // Post
    dateFullFormat(date) {
        return dateFormatReturn(date);
    },
    // Post
    dateFormatYDM(date) {
        if (this.nullCheck(date)) {
            return '';
        }

        date = new Date(date);
        const year = date.getFullYear();
        let month = date.getMonth() + 1;
        let day = date.getDate();

        if (month < 10) {
            month = `0${month}`;
        }

        if (day < 10) {
            day = `0${day}`;
        }

        return `${year}-${month}-${day}`;
    },
    // Post
    timeFormat(date) {
        date = new Date(date);

        let hour = String(date.getHours());
        let minute = String(date.getMinutes());

        if (hour.length === 1) {
            hour = `0${hour}`;
        }

        if (minute.length === 1) {
            minute = `0${minute}`;
        }

        return `${hour}:${minute}`;
    },
    // View
    dateFormatYDMByComma(dateFull) {
        if (this.nullCheck(dateFull)) {
            return '';
        }

        const date = dateFormatReturn(dateFull);
        const year = date.getFullYear();
        let month = date.getMonth() + 1;
        let day = date.getDate();

        if (month < 10) {
            month = `0${month}`;
        }

        if (day < 10) {
            day = `0${day}`;
        }

        return `${year}.${month}.${day}`;
    },
    // View
    dateFormatDMW(dateFull) {
        if (this.nullCheck(dateFull)) {
            return '';
        }

        const date = dateFormatReturn(dateFull);

        var week = new Array('일', '월', '화', '수', '목', '금', '토');

        let month = date.getMonth() + 1;
        let day = date.getDate();
        var dayLabel = week[date.getDay()];


        return `${month}.${day} (${dayLabel})`;
    },
    // View
    getTimeFormat(dateFull) {
        const date = dateFormatReturn(dateFull);
        let hour = date.getHours();
        let minute = date.getMinutes();

        if (hour < 10) {
            hour = `0${hour}`;
        }

        if (minute < 10) {
            minute = `0${minute}`;
        }

        return `${hour}:${minute}`;
    },
    // View
    dateCompareWithNow(date) {
        date = new Date(date);
        let dateNow = new Date();

        return date.getTime() - dateNow.getTime()
    },
    // View
    dateCompare(dateFullStart, dateFullEnd) {

        const dateStart = dateFormatReturn(dateFullStart);
        const dateEnd = dateFormatReturn(dateFullEnd);

        const yearStart = dateStart.getFullYear();
        let monthStart = dateStart.getMonth() + 1;
        let dayStart = dateStart.getDate();

        const yearEnd = dateEnd.getFullYear();
        let monthEnd = dateEnd.getMonth() + 1;
        let dayEnd = dateEnd.getDate();

        if (yearStart == yearEnd && monthStart == monthEnd && dayStart == dayEnd) {
            return true;
        } else return false;
    },
    // View
    numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    },
    msToDate(data){
        let dates =  Math.floor((data)/(1000*60*60*24));
        return dates;
    }
};
