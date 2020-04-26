    const entityEdit = {
        key: 'dataId',
        template: '#entity-edit-tpl',
        methods: {},
        props: {
            id: {
                default: 0
            },
            entity: {
                type: String
            }
        },
        watch: {
            dataId: function(val) {
                if (this.dataId > 0) {
                    this.modalVisible = true;
                    var getItem = MainFacade.getEntity(this.entity).getItem(this.dataId);
                    var data = getItem.then(data => {
                        for (var i in data) this.data[i] = data[i];
                        setTimeout(() => {
                            this.modalVisible = false
                        }, 500);
                    });
                }
            }
        },
        data() {
            var scheme = MainFacade.getScheme()[this.entity];
            var data = {}
            for (var i in scheme) {
                scheme[i].hidden = false;
                data[i] = null;
                scheme[i].values = [];
            };
            scheme.id.hidden = true;
            if (this.id > 0) setTimeout(() => this.dataId = parseInt(this.id, 10), 0);
            setTimeout(() => this.loadAllSelectFields(), 30);
            return {
                data: data,
                extData: [],
                scheme: scheme,
                toastVisible: false,
                dataId: null,
                modalVisible: false
            };
        },
        methods: {
            del() {
                this.modalVisible = true;
                MainFacade.getEntity(this.entity).delete(this.dataId).then((result) => {
                    this.modalVisible = false;
                    this.dataId = null
                    this.$emit('page-back', () => ons.notification.toast("Удалено " + this.data.id, { timeout: 2000 }));
                });
            },
            save() {
                this.modalVisible = true;
                MainFacade.getEntity(this.entity).save(this.data).then((result) => {
                    this.modalVisible = false;
                    this.dataId = result.id;
                    ons.notification.toast("Сохранено", { timeout: 2500 })
                });
            },
            upload(field, event) {
                this.data[field] = event.target.files[0];
            },
            loadAllSelectFields() {
                var call = async() => {
                    var scheme = this.scheme;
                    for (var i in scheme) {
                        if (scheme[i].type === "select") {
                            var list = await MainFacade.getEntity(scheme[i].entity).getList();
                            scheme[i].values = list;
                        }
                    };
                    this.scheme = scheme;
                }
                call();
            }
        }
    };