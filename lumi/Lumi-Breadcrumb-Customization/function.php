// Custom breadcrumb product
add_filter( 'woocommerce_get_breadcrumb', 'custom_breadcrumbs_remove_current_category', 20, 2 );
function custom_breadcrumbs_remove_current_category( $crumbs, $breadcrumb ) {
    if ( is_product() || is_product_category() ) {
        $category_chain = array();
        $main_term = null;

        if ( is_product() ) {
            global $post;
            $terms = get_the_terms( $post->ID, 'product_cat' ); // Lấy danh mục sản phẩm
        } elseif ( is_product_category() ) {
            $current_category = get_queried_object(); // Lấy danh mục hiện tại trên trang category
            $terms = array( $current_category );
        }

        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
            $main_term = array_shift( $terms ); // Lấy danh mục chính (hoặc danh mục hiện tại nếu là trang danh mục)

            // Nếu đang ở trang sản phẩm, thêm danh mục chính (con) vào breadcrumb
            if ( is_product() ) {
                $category_chain[] = array( $main_term->name, get_term_link( $main_term ) );
            }

            // Lấy danh mục cha (nếu có) và thêm vào breadcrumb
            $parent_id = $main_term->parent;
            while ( $parent_id ) {
                $parent_term = get_term( $parent_id, 'product_cat' );
                if ( is_wp_error( $parent_term ) ) break;

                $category_chain[] = array( $parent_term->name, get_term_link( $parent_term ) );
                $parent_id = $parent_term->parent;
            }

            // Thêm danh mục vào breadcrumb (nhưng bỏ danh mục hiện tại nếu đang ở trang danh mục)
            foreach ( $category_chain as $category ) {
                if ( ! is_product_category() || $category[0] !== $main_term->name ) {
                    array_splice( $crumbs, 1, 0, array( $category ) );
                }
            }
        }

        // Nếu đang trên trang sản phẩm, thêm sản phẩm vào breadcrumb
        if ( is_product() ) {
            global $post;
            $product_link = get_permalink( $post->ID );
            $product_title = get_the_title( $post->ID );
            $crumbs[] = array( $product_title, $product_link );
        }
    }
    return $crumbs;
}

//Post breadcrumb
// Tùy chỉnh breadcrumb cho bài viết (post)
function custom_post_breadcrumbs() {
    if ( !is_single() || get_post_type() !== 'post' ) {
        return;
    }

    global $post;
    $crumbs = array();

    // Link Trang chủ
    $crumbs[] = array( 'Trang chủ', home_url() );

    // Lấy tất cả danh mục của bài viết
    $categories = get_the_category( $post->ID );
    if ( !empty( $categories ) ) {
        // Sắp xếp danh mục theo thứ tự cấp bậc (danh mục cha trước, danh mục con sau)
        usort($categories, function ($a, $b) {
            return ($a->parent < $b->parent) ? -1 : 1;
        });

        $category_chain = array();
        $main_category = end($categories); // Lấy danh mục sâu nhất (danh mục hiện tại)

        // Lấy tất cả danh mục cha (nếu có)
        $parent_id = $main_category->parent;
        while ( $parent_id ) {
            $parent_term = get_category( $parent_id );
            if ( is_wp_error( $parent_term ) ) break;

            array_unshift($category_chain, array( $parent_term->name, get_category_link( $parent_term->term_id ) ));
            $parent_id = $parent_term->parent;
        }

        // Thêm danh mục cha vào breadcrumb
        foreach ( $category_chain as $category ) {
            $crumbs[] = $category;
        }

        // Thêm danh mục hiện tại (con cuối cùng)
        $crumbs[] = array( $main_category->name, get_category_link( $main_category->term_id ) );
    }

    // Thêm tiêu đề bài viết (không có link)
    $crumbs[] = array( get_the_title(), '' );

    // Hiển thị breadcrumb
    echo '<nav class="custom-breadcrumbs">';
    foreach ( $crumbs as $index => $crumb ) {
        if ( !empty( $crumb[1] ) ) {
            echo '<a href="' . esc_url( $crumb[1] ) . '">' . esc_html( $crumb[0] ) . '</a>';
        } else {
            echo '<span>' . esc_html( $crumb[0] ) . '</span>';
        }
        if ( $index < count( $crumbs ) - 1 ) {
            echo ' / ';
        }
    }
    echo '</nav>';
}

// Hiển thị breadcrumb trên trang bài viết
add_action( 'tha_content_top', 'custom_post_breadcrumbs' );
