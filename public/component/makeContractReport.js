const makeContractReport = {
    template: "#make-contract-report-tpl",
    props: ['toggleMenu'],
    components: {
        customToolbar
    },
    mounted() {
        this.refresh();
    },
    methods: {
        async refresh() {
            this.dataTable = await MainFacade.getEntity('contract').getList();

            /*                loadAllSelectFields() {
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

            */

        },
    },
    data() {
        return {
            entity: 'contract',
            scheme: MainFacade.getScheme()['contract'],
            dataTable: [

            ]
        }
    }
}