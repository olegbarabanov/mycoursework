const entityList = {
    key: 'entity-list',
    template: '#entity-list-tpl',
    props: {
        entity: {
            type: String
        },
        repaint: {
            type: String,
            default: "test"
        }
    },
    data() {
        return {
            list: [],
            state: 'initial',
            switchMode: false,
            scheme: MainFacade.getScheme()[this.entity],
            callPhone: '',
            popoverPhoneVisible: false,
            popoverPhoneTarget: null,
            popoverPhoneDirection: 'left',
            coverPhoneTarget: false,
            filter: []
        }
    },
    mounted() {
        this.refresh();
    },
    watch: {
        repaint() {
            this.refresh();
        }
    },
    methods: {
        refresh(done) {
            MainFacade.getEntity(this.entity).getList(this.filter).then(data => {
                this.list = data;
                setTimeout(() => {
                    if (done) done()
                }, 700)
            });
        },
        edit(id) {
            this.$emit('push-page', {
                extends: entityEdit,
                onsNavigatorProps: {
                    entity: this.entity,
                    id: id
                }
            });
        },
        showPhonePopup(phone, targetElement) {
            this.callPhone = phone;
            this.popoverPhoneTarget = targetElement;
            this.popoverPhoneVisible = true;
        }
    }
};