<!-- Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <form action="" method="POST" id="editProductForm">
        @csrf
        <input type="hidden" id="product_id">

        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="errorMsgContainer">

                </div>
                <div class="form-group my-2">
                    <label for="name">Product Name</label>
                    <input type="text" class="form-control" name="name" id="product_name" placeholder="Product Name">
                </div>
                <div class="form-group my-2">
                    <label for="price">Product Price</label>
                    <input type="text" class="form-control" name="price" id="product_price" placeholder="Product Price">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary edit_product">Update Product</button>
            </div>
            </div>
        </div>
    </form>
</div>