    const entity = {
        key: 'entity',
        template: '#entity-tpl',
        props: {
            entity: {
                type: String,
                default: ""
            }
        },
        components: {
            customToolbar
        },
        watch: {
            entity: function(val) {
                this.pageStack[0].onsNavigatorProps.entity = this.entity
            }
        },
        methods: {
            refresh(data) {
                this.pageStack.shift();

                setTimeout(() => this.pageStack.unshift({
                    extends: entityList,
                    onsNavigatorProps: {
                        entity: this.entity
                    }
                }) && this.pageStack.pop() && data(), 30);
            }
        },
        data() {
            return {
                pageStack: [{
                    extends: entityList,
                    onsNavigatorProps: {
                        entity: this.entity
                    }
                }]
            };
        },
    };