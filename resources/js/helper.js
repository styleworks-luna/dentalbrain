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

        console.log(path);

        return path;
    }
};
