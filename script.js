function likeProduct(productId) {
    $.ajax({
        type: 'POST',
        url: 'like_product.php',
        data: { action: 'like', productId: productId },
        success: function (response) {
            if (response.status === 'success') {
                updateLikeCount(productId, response.likeCount);
            } else if (response.status === 'error' && response.message === 'User not authenticated.') {
                // Redirect to the sign-in page
                window.location.href = 'sign_in.php';
            } else {
                console.log(response);
                // Display an error message to the user
                alert('Error liking the product. Check the console for details.');
            }
        },
        error: function (xhr, status, error) {
            console.log(xhr.responseText);
            // Display an error message to the user
            //alert('Error liking the product. Check the console for details.');
            window.location.href='index.php?pageId=1';
        }
    });
}

function unlikeProduct(productId) {
    $.ajax({
        type: 'POST',
        url: 'unlike_product.php',
        data: { action: 'unlike', productId: productId },
        success: function (response) {
            if (response.status === 'success') {
                updateLikeCount(productId, response.likeCount);
            } else if (response.status === 'error' && response.message === 'User not authenticated.') {
                // Redirect to the sign-in page
                window.location.href = 'sign_in.php';
            } else {
                console.log(response);
                // Display an error message to the user
                alert('Error unliking the product. Check the console for details.');
            }
        },
        error: function (xhr, status, error) {
            console.log(xhr.responseText);
            // Display an error message to the user
            //alert('Error unliking the product. Check the console for details.');
            window.location.href='index.php?pageId=1';
        }
    });
}

function updateLikeCount(productId, likeCount) {
    // Update the like count immediately
    $('#like-count-' + productId).text(likeCount + ' Likes');
}

$(document).ready(function () {
    $('.like-button').click(function () {
        var productId = $(this).data('product-id');
        likeProduct(productId);
    });

    $('.unlike-button').click(function () {
        var productId = $(this).data('product-id');
        unlikeProduct(productId);
    });
});
