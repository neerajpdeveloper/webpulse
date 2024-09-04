<?php



if(!isset($routes))

{ 

    $routes = \Config\Services::routes(true);

}



$routes->group('/wpsadmin/', ['namespace' => 'App\Modules\Admin\Controllers'], function($subroutes){



	/*** Route for Dashboard ***/
    // Admin Login And Dasboard
    $subroutes->add('/', 'Admin::index');
    $subroutes->match(['get','post'],'auth', 'Admin::auth');
    $subroutes->match(['get','post'],'add_category', 'Category::add_category');
    $subroutes->get('logout', 'Admin::logout');
    $subroutes->get('dashboard', 'Dashboard::index',['filter' => 'AuthGuard']);
    // Category
    $subroutes->match(['get','post'],'manage-category', 'Category::index',['filter' => 'AuthGuard']);
    $subroutes->match(['get','post'],'manage-category/(:num)', 'Category::index/$1',['filter' => 'AuthGuard']);
    $subroutes->match(['get','post'],'add-category/(:num)', 'Category::add_category/$1',['filter' => 'AuthGuard']);
    $subroutes->match(['get','post'],'edit-category/(:num)', 'Category::edit_category/$1',['filter' => 'AuthGuard']);
    // location 
    $subroutes->match(['get','post'],'manage-location', 'Location::index',['filter' => 'AuthGuard']);
    $subroutes->match(['get','post'],'add-country', 'Location::add_country',['filter' => 'AuthGuard']);
    $subroutes->match(['get','post'],'edit-country/(:num)', 'Location::edit_country/$1',['filter' => 'AuthGuard']);
    $subroutes->match(['get','post'],'manage-location/state/(:num)', 'Location::state/$1',['filter' => 'AuthGuard']);
    $subroutes->match(['get','post'],'add-state/(:num)', 'Location::add_state/$1',['filter' => 'AuthGuard']);
    $subroutes->match(['get','post'],'edit-state/(:num)', 'Location::edit_state/$1',['filter' => 'AuthGuard']);
    $subroutes->match(['get','post'],'manage-location/city/(:num)', 'Location::city/$1',['filter' => 'AuthGuard']);
    $subroutes->match(['get','post'],'add-city/(:num)', 'Location::add_city/$1',['filter' => 'AuthGuard']);
    $subroutes->match(['get','post'],'edit-city/(:num)', 'Location::edit_city/$1',['filter' => 'AuthGuard']);
    // banner 
    $subroutes->match(['get','post'],'manage-banner', 'Banner::index',['filter' => 'AuthGuard']);
    $subroutes->match(['get','post'],'add-banner', 'Banner::add_banner',['filter' => 'AuthGuard']);
    $subroutes->match(['get','post'],'edit-banner/(:num)', 'Banner::edit_banner/$1',['filter' => 'AuthGuard']);
    // Blog 
    $subroutes->match(['get','post'],'manage-blog', 'Blog::index',['filter' => 'AuthGuard']);
    $subroutes->match(['get','post'],'add-blog', 'Blog::add_blog',['filter' => 'AuthGuard']);
    $subroutes->match(['get','post'],'edit-blog/(:num)', 'Blog::edit_blog/$1',['filter' => 'AuthGuard']);
    // Products 
    $subroutes->match(['get','post'],'manage-product', 'Product::index',['filter' => 'AuthGuard']);
    $subroutes->match(['get','post'],'manage-product/(:num)', 'Product::index/$1',['filter' => 'AuthGuard']);
    $subroutes->match(['get','post'],'add-product', 'Product::add_product',['filter' => 'AuthGuard']);
    $subroutes->match(['get','post'],'add-product/(:num)', 'Product::add_product/$1',['filter' => 'AuthGuard']);
    $subroutes->match(['get','post'],'edit-product/(:num)', 'Product::edit_product/$1',['filter' => 'AuthGuard']);
   
    // Color
    $subroutes->match(['get','post'],'manage-color', 'Color::index',['filter' => 'AuthGuard']);
    $subroutes->match(['get','post'],'add-color', 'Color::add_color',['filter' => 'AuthGuard']);
    $subroutes->match(['get','post'],'edit-color/(:num)', 'Color::edit_color/$1',['filter' => 'AuthGuard']);
    // Size
    $subroutes->match(['get','post'],'manage-size', 'Size::index',['filter' => 'AuthGuard']);
    $subroutes->match(['get','post'],'add-size', 'Size::add_size',['filter' => 'AuthGuard']);
    $subroutes->match(['get','post'],'edit-size/(:num)', 'Size::edit_size/$1',['filter' => 'AuthGuard']);
    // Brand
    $subroutes->match(['get','post'],'manage-brand', 'Brand::index',['filter' => 'AuthGuard']);
    $subroutes->match(['get','post'],'add-brand', 'Brand::add_brand',['filter' => 'AuthGuard']);
    $subroutes->match(['get','post'],'edit-brand/(:num)', 'Brand::edit_brand/$1',['filter' => 'AuthGuard']);

   
    // Faqs 
   $subroutes->match(['get','post'],'manage-faqs', 'Faqs::index',['filter' => 'AuthGuard']);
   $subroutes->match(['get','post'],'manage-faqs/(:num)', 'Faqs::index/$1',['filter' => 'AuthGuard']);
   $subroutes->match(['get','post'],'add-faqs/(:num)', 'Faqs::add_faqs/$1',['filter' => 'AuthGuard']);
   $subroutes->match(['get','post'],'edit-faqs/(:num)', 'Faqs::edit_faqs/$1',['filter' => 'AuthGuard']);

    // Faqs 
    $subroutes->match(['get','post'],'manage-testimonial', 'Testimonial::index',['filter' => 'AuthGuard']);
    $subroutes->match(['get','post'],'add-testimonial', 'Testimonial::add_testimonial',['filter' => 'AuthGuard']);
    $subroutes->match(['get','post'],'edit-testimonial/(:num)', 'Testimonial::edit_testimonial/$1',['filter' => 'AuthGuard']);
   
    // Enquiry 
    $subroutes->match(['get','post'],'manage-enquiries/(:num)', 'Enquiry::index/$1',['filter' => 'AuthGuard']);
    $subroutes->match(['get','post'],'enquiries/(:num)', 'Enquiry::details/$1',['filter' => 'AuthGuard']);

    // pages 
    $subroutes->match(['get','post'],'manage-pages', 'Staticpages::index',['filter' => 'AuthGuard']);
    $subroutes->match(['get','post'],'add-new-page', 'Staticpages::add_page',['filter' => 'AuthGuard']);
    $subroutes->match(['get','post'],'edit-page/(:num)', 'Staticpages::edit_page/$1',['filter' => 'AuthGuard']);

     // Subdomain Home  
     $subroutes->match(['get','post'],'subhomecontent', 'SubdomainHome::index',['filter' => 'AuthGuard']);
     $subroutes->match(['get','post'],'subhomecontent/edit/(:num)', 'SubdomainHome::edit_lochome/$1',['filter' => 'AuthGuard']);

         // Subdomain Home  
         $subroutes->match(['get','post'],'subcontent', 'SubdomainCategory::index',['filter' => 'AuthGuard']);
         $subroutes->match(['get','post'],'subcontent/add', 'SubdomainCategory::add_new/$1',['filter' => 'AuthGuard']);
         $subroutes->match(['get','post'],'subcontent/edit/(:num)', 'SubdomainCategory::edit_loccate/$1',['filter' => 'AuthGuard']);
    

});

?>