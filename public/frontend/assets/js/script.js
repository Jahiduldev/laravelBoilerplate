const site_url = "http://127.0.0.1:8000/";

$("body").on("keyup", "#search", function () {
    let text = $("#search").val();
    if (text.length > 0) {
        $.ajax({
            type: "POST",
            url: site_url + "search-product",
            data: { search: text },
            beforSend: function (request) {
                return request.setRequestHeader(
                    "X-CSRF-TOKEN",
                    ('meta[name="csrf_token"]')
                );
            },
            success: function (response) {
                $(".searchProducts").html(response);
            },
        });
    }
    if (text.length < 1) {
        $(".searchProducts").html("");
    }
});

function search_result_show(){
    $(".searchProducts").slideDown();
}

function search_result_hide(){
    $(".searchProducts").slideUp();
}
