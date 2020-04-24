class EntityRepository {
    constructor() {
        this.controller = ""
    }

    async getList(filter) {
        let formData = new FormData();
        filter.forEach((f, i) => {
            formData.append(`${f.type}[${i}][value]`, f.value);
            formData.append(`${f.type}[${i}][field]`, f.field);
        });
        let queryString = new URLSearchParams(formData);
        let response = await fetch(`/api/v1/${this.controller}?` + queryString);
        let result = await response.json();
        return result;
    }

    async getItem(id) {
        let response = await fetch(`/api/v1/${this.controller}/${id}`);
        let result = await response.json();
        return result[0];
    }

    async save(data) {
        var formData = new FormData();
        for (var key in data) formData.append(key, data[key]);

        if (data.id) {
            var response = await fetch(`/api/v1/${this.controller}/${data.id}/update`, {
                method: 'POST',
                body: formData
            });
        } else {
            var response = await fetch(`/api/v1/${this.controller}/insert`, {
                method: 'POST',
                body: formData
            });
        };

        return await response.json();
    }

    async delete(id) {
        let response = await fetch(`/api/v1/${this.controller}/${id}/delete`, {
            method: 'POST',
        });
        let result = await response.json();
        return result[0];
    }

    async getScheme() {
        let response = await fetch(`/api/v1/${this.controller}/scheme`);
        let result = await response.json();
        return result;
    }

}