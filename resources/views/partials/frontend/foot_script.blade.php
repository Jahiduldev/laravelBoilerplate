<script src="{{ asset('frontend/assets/js/vendor/modernizr-3.6.0.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/vendor/jquery-migrate-3.3.0.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/vendor/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/slick.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/jquery.syotimer.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/waypoints.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/wow.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/slider-range.js')}}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/magnific-popup.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/select2.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/counterup.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/images-loaded.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/isotope.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/scrollup.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/jquery.vticker-min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/jquery.theia.sticky.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/jquery.elevatezoom.js') }}"></script>
    
    <!-- Template  JS -->
    <script src="{{ asset('frontend/assets/js/main.js?v=5.3') }}"></script>
    <script src="{{ asset('frontend/assets/js/shop.js?v=5.3') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    {{-- toaster --}}
    <script src="{{ asset('adminbackend/assets/js/code.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/script.js') }}"></script>
    <script>
        @if(Session::has('message'))
        var type = "{{ Session::get('alert-type','info') }}"
        switch(type){
           case 'info':
           toastr.info(" {{ Session::get('message') }} ");
           break;
        
           case 'success':
           toastr.success(" {{ Session::get('message') }} ");
           break;
        
           case 'warning':
           toastr.warning(" {{ Session::get('message') }} ");
           break;
        
           case 'error':
           toastr.error(" {{ Session::get('message') }} ");
           break; 
        }
        @endif 
    </script>

<script type="text/javascript">
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf_token"]').attr('content')
        }
    })
    // start product view modal
    function product_view(id){
        $.ajax({
            type: "GET",
            url: "/product/view/"+id,
            dataType: "json",
            success: function (response) {
                $('#p_id').val('');
                $('#p_qty').val('');
                $('#p_name').text('');
                $('#p_code').text('');
                $('#p_category').text('');
                $('#p_brand').text('');
                $('#p_img').attr('src','');
                $('#p_price').text('');
                $('#old_p_price').text('');
                $('#aviable').text('');
                $('#stockout').text('');
                $('select[name="size"]').empty();
                $('select[name="color"]').empty();
                
                $('#p_id').val(id);
                $('#p_qty').val(1);
                $('#p_name').text(response.product.product_name);
                $('#p_code').text(response.product.product_code);
                $('#p_category').text(response.product.category.category_name);
                $('#p_brand').text(response.product.brand.brand_name);
                $('#p_img').attr('src',response.product.product_thumbnail);
                if(response.product.discount_price == null){
                    $('#p_price').text('$'+response.product.selling_price);
                }else{
                    $('#p_price').text('$'+response.product.discount_price);
                    $('#old_p_price').text('$'+response.product.selling_price);
                }
                if(response.product.product_qty > 0){
                    $('#aviable').text('aviable');
                }else{
                    $('#stockout').text('stockout');
                }
                if(response.size != ""){
                    $('#size_area').show();
                    $.each(response.size, function(key, value){
                        $('select[name="size"]').append('<option value="' + value + '">' + value + '</option>');
                    })
                }else{
                    $('#size_area').hide();
                }
                if(response.color != ""){
                    $('#color_area').show();
                    $.each(response.color, function(key, value){
                        $('select[name="color"]').append('<option value="' + value + '">' + value + '</option>');
                    })
                }else{
                    $('#color_area').hide();
                }
            }
        });
    }

    // add to cart
    function addToCart(){
        var p_name = $('#p_name').text();
        var id = $('#p_id').val();
        var p_color = $('#color option:selected').text();
        var p_size = $('#size option:selected').text();
        var p_vendor_id = $('#p_vendor_id').text();
        var p_qty = $('#p_qty').val();

        $.ajax({
            type: "POST",
            url: "/cart/data/store/"+id,
            data: {
                p_name,
                p_color,
                p_size,
                p_qty,
                p_vendor_id,
            },
            dataType: "json",
            success: function (response) {
                $('#close_modal').click();
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 3000
                })
                if ($.isEmptyObject(response.error)) {
                    Toast.fire({
                        type: 'success',
                        title: response.success,
                    })
                } else {
                    Toast.fire({
                        type: 'error',
                        title: response.error,
                    })
                }
                miniCart()
            }
        });
    }
    // add to cart details
    function addToCartDetails(){
        var p_name = $('#p_d_name').text();
        var id = $('#p_d_id').val();
        var p_color = $('#color_d option:selected').text();
        var p_size = $('#size_d option:selected').text();
        var p_qty = $('#p_d_qty').val();
        var p_vendor_id = $('#d_vendor_id').val();

        $.ajax({
            type: "POST",
            url: "/cart/data/store/"+id,
            data: {
                p_name,
                p_color,
                p_size,
                p_qty,
                p_vendor_id,
            },
            dataType: "json",
            success: function (response) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 3000
                })
                if ($.isEmptyObject(response.error)) {
                    Toast.fire({
                        type: 'success',
                        title: response.success,
                    })
                } else {
                    Toast.fire({
                        type: 'error',
                        title: response.error,
                    })
                }
                miniCart()
            }
        });
    }
    // add to cart wishlist
    function addToCartWishList(id){
        var p_name = $('#p_w_name').text();
        var p_color = $('#color_w option:selected').text();
        var p_size = $('#size_w option:selected').text();
        var p_qty = $('#p_w_qty').val();
        var p_vendor_id = $('#w_vendor_id').val();

        $.ajax({
            type: "POST",
            url: "/cart/data/store/"+id,
            data: {
                p_name,
                p_color,
                p_size,
                p_qty,
                p_vendor_id,
            },
            dataType: "json",
            success: function (response) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 3000
                })
                if ($.isEmptyObject(response.error)) {
                    Toast.fire({
                        type: 'success',
                        title: response.success,
                    })
                } else {
                    Toast.fire({
                        type: 'error',
                        title: response.error,
                    })
                }
                miniCart()
            }
        });
    }
    // add to cart Compare
    function addToCartCompare(id){
        var p_name = $('#p_c_name').text();
        var p_color = $('#color_c option:selected').text();
        var p_size = $('#size_c option:selected').text();
        var p_qty = $('#p_c_qty').val();
        var p_vendor_id = $('#c_vendor_id').val();

        $.ajax({
            type: "POST",
            url: "/cart/data/store/"+id,
            data: {
                p_name,
                p_color,
                p_size,
                p_qty,
                p_vendor_id,
            },
            dataType: "json",
            success: function (response) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 3000
                })
                if ($.isEmptyObject(response.error)) {
                    Toast.fire({
                        type: 'success',
                        title: response.success,
                    })
                } else {
                    Toast.fire({
                        type: 'error',
                        title: response.error,
                    })
                }
                miniCart()
            }
        });
    }

    function miniCart(){
        $.ajax({
            type: 'GET',
            url: '/product/mini/cart',
            dataType: 'json',
            success: function (response) {
                $('#whisListProductCount').text(response.whisListProductCount)
                $('#compareListProductCount').text(response.compareListProductCount)
                $('#cartQty').text(response.cartQty)
                $('#cartTotal').text('$'+response.cartTotal)
                var miniCart = ""
                $.each(response.carts, function(key, value){
                    miniCart += `
                        <li>
                            <div class="shopping-cart-img">
                                <a href="shop-product-right.html"><img alt="Nest"
                                        src="/${value.options.image}" style="width:50px; height:50px" /></a>
                            </div>
                            <div class="shopping-cart-title" >
                                <h4><a href="shop-product-right.html">${value.name}</a></h4>
                                <h4><span>${value.qty} × </span>$${value.price}</h4>
                            </div>
                            <div class="shopping-cart-delete">
                                <a href="#" id="${value.rowId}" onclick="miniCartRemove(this.id)"><i class="fi-rs-cross-small"></i></a>
                            </div>
                        </li>
                        <hr/>
                    `
                });
                $('#miniCart').html(miniCart);
            }
        })
    }
    miniCart()
    function miniCartRemove(id) { 
        $.ajax({
            type: "GET",
            url: "/minicart/product/remove/"+id,
            dataType: "json",
            success: function (response) {
                miniCart()
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 3000
                })
                if ($.isEmptyObject(response.error)) {
                    Toast.fire({
                        type: 'success',
                        title: response.success,
                    })
                } else {
                    Toast.fire({
                        type: 'error',
                        title: response.error,
                    })
                }
            }
        });
    }
    function addToWishList(id){
        $.ajax({
            type: "POST",
            url: "/add-to-wish-list/"+id,
            dataType: "json",
            success: function (response) {
                $('#whisListProductCount').text(response.whisListProductCount);
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                })
                if ($.isEmptyObject(response.error)) {
                    Toast.fire({
                        type: 'success',
                        icon: 'success',
                        title: response.success,
                    })
                } else {
                    Toast.fire({
                        type: 'error',
                        icon: 'error',
                        title: response.error,
                    })
                }
            }
        });
    }
    function addToCompare(id){
        $.ajax({
            type: "POST",
            url: "/add-to-compare/"+id,
            dataType: "json",
            success: function (response) {
                $('#compareListProductCount').text(response.compareListProductCount)
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                })
                if ($.isEmptyObject(response.error)) {
                    Toast.fire({
                        type: 'success',
                        icon: 'success',
                        title: response.success,
                    })
                } else {
                    Toast.fire({
                        type: 'error',
                        icon: 'error',
                        title: response.error,
                    })
                }
            }
        });
    }

    function myCart(){
        $.ajax({
            type: 'GET',
            url: '/get/cart/product',
            dataType: 'json',
            success: function (response) {
                var rows = "";
                $.each(response.carts, function(key, value){
                    rows += `
                        <tr class="pt-30">
                                <td class="image product-thumbnail pt-40"><img src="${value.options.image}"
                                        alt="#"></td>
                                <td class="product-des product-name">
                                    <h6 class="mb-5"><a class="product-name mb-10 text-heading"
                                            href="shop-product-right.html">${value.name}</a></h6>
                                </td>
                                <td class="price" data-title="Price">
                                    <h4 class="text-body">$${value.price}</h4>
                                </td>
                                <td class="price" data-title="Price">
                                    ${value.options.color == null ? '<span>....</span>' : `<h6 class="text-body">${value.options.color}</h6>`}
                                </td>
                                <td class="price" data-title="Price">
                                    ${value.options.size == null ? '<span>....</span>' : `<h6 class="text-body">${value.options.size}</h6>`}
                                </td>
                                <td class="text-center detail-info" data-title="Stock">
                                    <div class="detail-extralink mr-15">
                                        <div class="detail-qty border radius">
                                            <a type="submit" id="${value.rowId}" onclick="cartDecrement(this.id)" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                                            <input type="text" name="quantity" class="qty-val" value="${value.qty}"
                                                min="1">
                                            <a type="submit" id="${value.rowId}" onclick="cartIncrement(this.id)" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                                        </div>
                                    </div>
                                </td>
                                <td class="price" data-title="Price">
                                    <h4 class="text-brand">${value.subtotal}</h4>
                                </td>
                                <td class="action text-center" data-title="Remove">
                                    <a type="submit" id="${value.rowId}" onclick="cartRemove(this.id)" class="text-body" ><i
                                            class="fi-rs-trash"></i></a></td>
                        </tr>
                    `;
                });
                $('#myCartpage').html(rows);
            }
        })
    }
    myCart();

    function cartRemove(id) { 
        $.ajax({
            type: "GET",
            url: "/cart/remove/"+id,
            dataType: "json",
            success: function (response) {
                myCart();
                miniCart();
                couponCalculation();
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 3000
                })
                if ($.isEmptyObject(response.error)) {
                    Toast.fire({
                        type: 'success',
                        title: response.success,
                    })
                } else {
                    Toast.fire({
                        type: 'error',
                        title: response.error,
                    })
                }
            }
        });
    }

    function cartDecrement(id) { 
        $.ajax({
            type: "GET",
            url: "/cart/decrement/"+id,
            dataType: "json",
            success: function (response) {
                myCart();
                miniCart();
                couponCalculation();
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 3000
                })
                if ($.isEmptyObject(response.error)) {
                    Toast.fire({
                        type: 'success',
                        title: response.success,
                    })
                } else {
                    Toast.fire({
                        type: 'error',
                        title: response.error,
                    })
                }
            }
        });
    }
    function cartIncrement(id) { 
        $.ajax({
            type: "GET",
            url: "/cart/increment/"+id,
            dataType: "json",
            success: function (response) {
                myCart();
                miniCart();
                couponCalculation();
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 3000
                })
                if ($.isEmptyObject(response.error)) {
                    Toast.fire({
                        type: 'success',
                        title: response.success,
                    })
                } else {
                    Toast.fire({
                        type: 'error',
                        title: response.error,
                    })
                }
            }
        });
    }

    function applyCoupon(){
        var coupon_name = $('#coupon_name').val();
        $.ajax({
            type: "POST",
            url: "/coupon-apply/",
            dataType: "json",
            data: {coupon_name},
            success: function (response) {
                if(response.validity === true){
                    couponCalculation()
                    $('#coupon_field').hide();
                }
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                })
                if ($.isEmptyObject(response.error)) {
                    Toast.fire({
                        type: 'success',
                        icon: 'success',
                        title: response.success,
                    })
                } else {
                    Toast.fire({
                        type: 'error',
                        icon: 'error',
                        title: response.error,
                    })
                }
            }
        });
    }

    function couponCalculation() { 
        $.ajax({
            type: "GET",
            url: "/coupon-calculation/",
            dataType: "json",
            success: function (response) {
                if(response.total){
                    $('#coupon_cal_field').html(`
                                        <tr>
                                            <td class="cart_total_label">
                                                <h6 class="text-muted">Sub Total</h6>
                                            </td>
                                            <td class="cart_total_amount">
                                                <h4 class="text-brand text-end">$${response.total}</h4>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="cart_total_label">
                                                <h6 class="text-muted">Total Amount</h6>
                                            </td>
                                            <td class="cart_total_amount">
                                                <h4 class="text-brand text-end">$${response.total}</h4>
                                            </td>
                                        </tr>
                    `)
                }else{
                    $('#coupon_cal_field').html(`
                                        <tr>
                                            <td class="cart_total_label">
                                                <h6 class="text-muted">Sub Total</h6>
                                            </td>
                                            <td class="cart_total_amount">
                                                <h4 class="text-brand text-end">$${response.subtotal}</h4>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="cart_total_label">
                                                <h6 class="text-muted">Coupon Name</h6>
                                            </td>
                                            <td class="cart_total_amount">
                                                <h4 class="text-brand text-end">${response.coupon_name} <a type="submit" onclick="couponRemove()"><i class="fi-rs-trash"></i></a></h4>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="cart_total_label">
                                                <h6 class="text-muted">Coupon Discount</h6>
                                            </td>
                                            <td class="cart_total_amount">
                                                <h4 class="text-brand text-end">$${response.coupon_discount}</h4>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="cart_total_label">
                                                <h6 class="text-muted">Discount</h6>
                                            </td>
                                            <td class="cart_total_amount">
                                                <h4 class="text-brand text-end">$${response.discount_amount}</h4>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="cart_total_label">
                                                <h6 class="text-muted">Grand Total</h6>
                                            </td>
                                            <td class="cart_total_amount">
                                                <h4 class="text-brand text-end">$${response.total_amount}</h4>
                                            </td>
                                        </tr>
                    `)
                }
            }
        });
    }
    couponCalculation();

    function couponRemove(){
        $.ajax({
            type: "GET",
            url: "/coupon-remove/",
            dataType: "json",
            success: function (response) {
                couponCalculation();
                $('#coupon_field').show();
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    
                    showConfirmButton: false,
                    timer: 3000
                })
                if ($.isEmptyObject(response.error)) {
                    Toast.fire({
                        type: 'success',
                        icon: 'success',
                        title: response.success,
                    })
                } else {
                    Toast.fire({
                        type: 'error',
                        icon: 'error',
                        title: response.error,
                    })
                }
            }
        });
    }
    </script>
    {{-- style="margin: -85px 1px 0px;"style="margin: -73px 74px 14px; width: 146px;" --}}