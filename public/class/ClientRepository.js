class ClientRepository extends EntityRepository {
    constructor() {
        super();
        this.controller = "client";
    }
}