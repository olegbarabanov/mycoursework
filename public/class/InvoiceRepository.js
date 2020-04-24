class InvoiceRepository extends EntityRepository {
    constructor() {
        super();
        this.controller = "invoice";
    }
}