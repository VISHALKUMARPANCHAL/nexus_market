
const FilterApp = {
    init: function() {
        this.bindEvents();
    },

    bindEvents: function() {
        $('.filter-checkbox').on('change', this.fetchFilteredProducts);
    },

    fetchFilteredProducts: function() {
        let formData = FilterApp.collectFilterData();
        FilterApp.updateEncodedURL(formData);

        $('#products-container').html(
            '<div class="loader"></div>'
        );

        $.ajax({
            url: 'http://localhost/ecommerceweb/catalog/product/list/',
            type: 'GET',
            data: formData,
            success: function(response) {
                let productContainer = $("#products-container");
                let extractedContent = $(response).find("#products-container").html();
                productContainer.empty();
                productContainer.html(extractedContent);

            },
            error: function(error) {
                console.log('Error fetching products:', error);
                $('#products-container').html('<p>Failed to load products. Please try again.</p>');
            }
        });
    },
    collectFilterData: function() {
        let filters = {};

        $('.filter-checkbox:checked').each(function() {
            let name = $(this).attr('name');
            if (!filters[name]) {
                filters[name] = [];
            }
            filters[name].push($(this).val());
        });
        console.log(filters);
        return filters;
    },

    syncPriceInputs: function() {
        $('#max-price').val($('#price-slider').val());
        FilterApp.fetchFilteredProducts();
    },

    debounce: function(func, delay) {
        let timer;
        return function() {
            clearTimeout(timer);
            timer = setTimeout(() => func.apply(this, arguments), delay);
        };
    },

    updateEncodedURL: function(filters) {
        try {
            // Convert object to JSON and encode with Base64
            let jsonString = JSON.stringify(filters);
            let encodedData = btoa(jsonString); // Base64 encode
            // let encodedData = (jsonString); // Base64 encode
            // Update the URL with encoded data
            window.history.pushState({}, '', `?data=${encodedData}`);
        } catch (error) {
            console.error('Encoding failed:', error);
        }
    },

    fetchProductsFromEncodedURL: function() {
        let urlParams = new URLSearchParams(window.location.search);
        let encodedData = urlParams.get('data');
        if (encodedData) {
            try {
                // Decode Base64 back to JSON
                let decodedData = atob(encodedData);
                // let decodedData = (encodedData);
                let filters = JSON.parse(decodedData);
                // console.log(filters);
                if (filters) {
                    FilterApp.restoreFilters(filters);
                    this.fetchFilteredProducts();
                }
            } catch (error) {
                console.error('Decoding failed:', error);
            }
        }
    },

    restoreFilters: function(filters) {
        $.each(filters, function(key, value) {
            if (Array.isArray(value)) {
                $('.filter-checkbox[name="' + key + '"]').each(function() {
                    $(this).prop('checked', value.includes($(this).val()));
                });
            } else {
                $('#' + key).val(value);
            }
        });
    },
    searchProducts: function() {
        $("#search-input").on('input', function() {
            let input = $("#search-input").val().toLowerCase();
            let products = $(".col-md-4").each(function() {
                let name = $(this).find(".card-title").text().trim().toLowerCase();
                if (name.includes(input)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }

            });
        });
    },
    sortProducts: function() {
        $("#sort-select").on('change', function() {
            let products = $(".col-md-4").toArray();
            let sortValue = $(this).val();

            products.sort((a, b) => {
                let priceA = parseFloat($(a).find(".product-price").text().substring(1));
                let priceB = parseFloat($(b).find(".product-price").text().substring(1));
                switch (sortValue) {
                    case 'price-asc':
                        return priceA - priceB;
                        break;
                    case 'price-desc':
                        return priceB - priceA;
                        break;
                }
            });

            $(".products-grid").empty();
            products.forEach(product => {
                $(".products-grid").append(product);
            });
        });
    },
    priceRange: function() {
        $("#minmaxfiltersubmit").on("click", function() {
            let products = $(".col-md-4").toArray();
            let min = parseInt($("#minmaxfilter").find("#min-price").val());
            let max = parseInt($("#minmaxfilter").find("#max-price").val());
            products.forEach(product => {
                let price = $(product).find(".product-price").text().substring(1);
                console.log(price);
                if (price >= min && price <= max) {
                    $(product).show();
                } else {
                    $(product).hide();
                }
            });
        });
    }

}

$(document).ready(function() {
    FilterApp.init();
    FilterApp.fetchProductsFromEncodedURL();
    FilterApp.searchProducts();
    FilterApp.sortProducts();
    FilterApp.priceRange();
});

function toggleAttribute(header) {
    // console.log(header);
    var options = header.nextElementSibling;
    if (options.classList.contains('active')) {
        options.classList.remove('active');
    } else {
        options.classList.add('active');
    }
}

document.querySelectorAll('.attribute-header').forEach(function(header) {
    header.addEventListener('click', function() {
        toggleAttribute(this);
    });
});