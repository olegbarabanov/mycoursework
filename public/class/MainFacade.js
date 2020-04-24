class MainFacade {
    static __setScheme(scheme) {
        this.__scheme = scheme;
    }

    static getScheme() {
        return this.__scheme;
    }

    static getEntity(str) {
        var entity = str[0].toUpperCase() + str.slice(1);
        entity = entity.replace(/_([a-z])/g, (g) => g[1].toUpperCase());
        var obj = null;
        eval(`obj = new ${entity}Repository()`);
        return obj;
    }

    static async loadAllSchemes() {
        return {
            "user": await this.getEntity("user").getScheme(),
            "invoice": await this.getEntity("invoice").getScheme(),
            "act": await this.getEntity("act").getScheme(),
            "contract": await this.getEntity("contract").getScheme(),
            "contract_stage": await this.getEntity("contract_stage").getScheme(),
            "contract_type": await this.getEntity("contract_type").getScheme(),
            "client": await this.getEntity("client").getScheme(),
            "role": await this.getEntity("role").getScheme(),
        }
    }
}