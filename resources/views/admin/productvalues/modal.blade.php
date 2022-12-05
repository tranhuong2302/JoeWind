<!-- Modal -->
<div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Create Product Attribute Value</h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="productAttributeValueId" id="productAttributeValueId">
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameWithTitle" class="form-label">Name</label>
                        <input
                            type="text"
                            id="nameWithTitle"
                            name="name"
                            class="form-control name"
                            placeholder="Enter Name"
                            disabled="disabled"
                        />
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col mb-0">
                        <label for="plus_price" class="form-label">Plus Price</label>
                        <input
                            type="text"
                            id="plus_price"
                            name="plus_price"
                            class="form-control plus_price"
                            placeholder="Enter plus price"
                        />
                    </div>
                    <div class="col mb-0">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input
                            type="text"
                            id="quantity"
                            name="quantity"
                            class="form-control quantity"
                            placeholder="Enter quantity"
                        />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Close
                </button>
                <button type="button" class="btn btn-primary saveBtn">Create</button>
            </div>
        </div>
    </div>
</div>

