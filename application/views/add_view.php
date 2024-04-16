<div class="form__add"> 
    <form id="product_form">
        <div> 
            <span><label for="sku">SKU</label></span>
            <span><input type="text" name="sku" id="sku" required>*</span>
        </div>
                    
        <div>
            <span><label for="name">Name</label></span>
            <span><input type="text" name="name" id="name" required>*</spa>
        </div>
        <div>
            <span><label for="price">Price ($)</label></span>
            <span><input type="number" min="0.0" name="price" id="price" step="1.0" required>*</span>
        </div>
        <div>
            <span><label for="types" placeholder="Select type">Type Switcher</label></span>
            <span><select name="types" id="productType">
                <?=$product_types;?>
            </select>
            </span>
        </div>

        <?=$products_add_block;?>
               
        <p>✷ - required fields</p> 
    </form>
</div>