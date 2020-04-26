async function init() {
    var schemes = await MainFacade.loadAllSchemes();
    MainFacade.__setScheme(schemes);

    new Vue({
        el: '#app',
        template: '#main-tpl',
        data() {
            return {
                currentPage: 'home',
                pages: {
                    client: {
                        name: "Клиенты",
                        component: "entity",
                        icon: "md-face"
                    },
                    contract: {
                        name: "Договора",
                        component: "entity",
                        icon: "md-folder"
                    },
                    invoice: {
                        name: "Счета",
                        component: "entity",
                        icon: "md-folder"
                    },
                    act: {
                        name: "Акты",
                        component: "entity",
                        icon: "md-folder"
                    },
                    user: {
                        name: "Пользователи",
                        component: "entity",
                        icon: "md-folder-person"
                    },
                    contract_stage: {
                        name: "Стадии контракта",
                        component: "entity",
                        icon: "md-present-to-all"
                    },
                    contract_type: {
                        name: "Типы контрактов",
                        component: "entity",
                        icon: "md-present-to-all"
                    },
                    role: {
                        name: "Роли сотрудников",
                        component: "entity",
                        icon: "md-present-to-all"
                    }
                },
                auth: false,
                openSide: false,
                typeComponent: 'homePage',
                modalVisible: false,
                supportPlatforms: ["opera", "firefox", "safari", "chrome", "ie", "android", "blackberry", "ios", "wp"],
                usePlatform: '',
                acts: [{}],
            };
        },
        watch: {
            usePlatform(val) {
                ons.forcePlatformStyling(val);
            }
        },
        mounted() {
            this.login();
        },
        components: {
            entity: entity,
            makeContractReport: makeContractReport,
            homePage: homePage
        },
        methods: {
            async logout() {
                await fetch("/api/v1/user/logout");
                this.auth = false;
                ons.notification.toast('Ваш сеанс завершен.', { timeout: 2000 });
                this.login();
            },
            async login() { // Async function authorization in server
                let authData = false;
                let response = await fetch("/api/v1/user/is_auth");
                if (response.ok) {
                    authData = await response.json();
                } else {
                    await ons.notification.alert("Ошибка HTTP: " + response.status);
                };

                while (true) {
                    if (authData) break;

                    var email = await ons.notification.prompt('Укажите Ваш email', { title: '<ons-icon icon="md-email-open" size="32px, material:24px"></ons-icon>', autofocus: true });
                    if (email) var password = await ons.notification.prompt('Укажите Ваш пароль?', { title: '<ons-icon icon="md-shield-security" size="32px, material:24px"></ons-icon>', cancelable: true, inputType: "password", autofocus: true });
                    if (email && password) {
                        var formData = new FormData();
                        formData.append("email", email);
                        formData.append("password", password);
                        let response = await fetch("/api/v1/user/login", {
                            method: 'POST',
                            body: formData
                        });
                        if (response.ok) {
                            authData = await response.json();
                            if (!authData) ons.notification.toast('Неверный пароль, попробуйте ещё раз', { timeout: 2000 });
                        } else {
                            await ons.notification.alert("Ошибка HTTP: " + response.status);
                        };
                    }
                }

                this.auth = true;
            }
        }
    });

};

Vue.use(VueOnsen);
init();