function csshero_theme_declarations(){
  // MAIN CONTAINER
  csshero_declare_item('body','Site Body');
  
  //Basic element
  csshero_declare_item('.btn','Button');
  csshero_declare_item('.btn.btn-lighter','Button Light');
  csshero_declare_item('.btn.btn-primary','Button Solid');
  csshero_declare_item('.item-thumbnail','Item Thumbnail');
  csshero_declare_item('.item-title','Item Title');
  csshero_declare_item('.date-block','Date Block');
  csshero_declare_item('#slider','Slider');
  
  
  // TOP AREA
  csshero_declare_item('header','Header Navigation');
  csshero_declare_item('#top-nav .navbar','Top Nav')
  csshero_declare_item('#top-nav .navbar.navbar-inverse li a','Top Menu Item');
  csshero_declare_item('.topnav-sidebar a','Top Nav Link');
  csshero_declare_item('#main-nav .navbar','Main Nav');
  csshero_declare_item('#main-nav .navbar-nav li a','Main Menu Item');
  csshero_declare_item('header .logo img','Logo');
  csshero_config_menu('.main-menu','.nav','Main Menu');
	
  // HEADERS
  csshero_declare_item('.page-heading','Page Heading');
  csshero_declare_item('.page-heading h1','Heading Title');
  csshero_declare_item('.breadcrumbs, .breadcrumbs a','Breadcrumbs');
	
  // POSTS
  csshero_config_post('.blog-item','.item-content','Blog Post');
  csshero_declare_item('.item-content h3 a','Blog Post Title');
  csshero_declare_item('.blog-item .item-thumbnail','Blog Post Thumbnail');
	
  // SINGLE
  csshero_config_post('body.single article.single-content','.single-post-content-text','Single Post');
  csshero_declare_item('.single .single-content-title','Single Post Title');
  csshero_declare_item('.single-content .item-meta','Single Post Meta Area');
  csshero_declare_item('.about-author','About Author');
	
  // COMMENTS
  new_csshero_config_comments('.commentlist','.comment','.comment-content');
  csshero_declare_item('article.comment .avatar-wrap','Comment Avatar');
  csshero_declare_item('.comment-edit .fn','Comment Author');
  csshero_declare_item('.comment.depth-2','Comment Depth 2');
  csshero_declare_item('.comment.depth-3','Comment Depth 3');
  csshero_declare_item('.comment.depth-4','Comment Depth 4');
	
  // RESPOND
  csshero_config_respond('.comments');
	
  // FOOTER AREA
  csshero_declare_item('footer','Footer Area');
  csshero_declare_item('footer a','Footer Links');
  csshero_declare_item('#bottom-nav','Bottom Nav');
  csshero_declare_item('footer .copyright','Footer Copyrights');
  csshero_declare_item('footer a.social-icon','Footer Social Icon');

	
  // PAGE
  csshero_config_post('body.page #content','.single-page-content','Single Page');

  //sidebar
	csshero_config_sidebar('#sidebar','.widget','Main Sidebar');
	csshero_config_sidebar('footer .normal-sidebar','.widget','Footer Sidebar');
}
