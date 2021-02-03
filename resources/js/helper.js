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
    }
};
