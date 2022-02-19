<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$route['default_controller']                                                   =    'welcome';
$route['404_override']                                                            =    '';
$route['translate_uri_dashes']                                              =    FALSE;
$route['admin']                                                                         =    "admin/C_admin";
$route['admin/dashboard']                                                    =    "admin/C_admin/dashBoard"; 
$route['logout']                                                                         =    "admin/C_admin/logout"; 
$route['admin/user_list']                                                        =    "admin/C_admin/userList"; 
$route['admin/add_edit_user']                                             =    "admin/C_admin/addEditUser"; 
$route['admin/add_edit_user/(.*)']                                     =    "admin/C_admin/addEditUser/$1*";
$route['admin/country_list']                                                 =    "admin/C_admin/countryList"; 
$route['admin/add_edit_country']                                      =    "admin/C_admin/addEditCountry"; 
$route['admin/add_edit_country/(.*)']                              =    "admin/C_admin/addEditCountry/$1*"; 
$route['admin/city_list']                                                         =    "admin/C_admin/cityList"; 
$route['admin/add_edit_city']                                              =    "admin/C_admin/addEditCity"; 
$route['admin/add_edit_city/(.*)']                                      =    "admin/C_admin/addEditCity/$1*"; 

$route['admin/area_list']                                                         =    "admin/C_admin/areaList"; 
$route['admin/add_edit_area']                                              =    "admin/C_admin/addEditArea"; 
$route['admin/add_edit_area/(.*)']                                      =    "admin/C_admin/addEditArea/$1*";
 
$route['admin/service_type_list']                                        =    "admin/C_admin/serviceTypeList"; 
$route['admin/add_edit_service_type']                             =    "admin/C_admin/addEditServiceType"; 
$route['admin/add_edit_service_type/(.*)']                     =    "admin/C_admin/addEditServiceType/$1*"; 
$route['admin/add_edit_questions']                                 =    "admin/C_admin/addEditQuestions"; 
$route['admin/add_edit_questions/(.*)']                         =    "admin/C_admin/addEditQuestions/$1*"; 

$route['admin/question_list']                                              =    "admin/C_admin/QuestionList"; 
$route['admin/question_list/(.*)']                                      =    "admin/C_admin/QuestionList/$1*"; 
$route['admin/admin_user_list']                                                        =    "admin/C_admin/listAdminUsers"; 

$route['admin/add_stafs']                                                     =    "admin/C_admin/addEditAdmin"; 
$route['admin/add_stafs/(.*)']                                             =    "admin/C_admin/addEditAdmin/$1*"; 
$route['admin/list_audit_trial']                                            =    "admin/C_admin/listAuditTrail"; 
$route['admin/set_permission']                                           =    "admin/C_admin/setPermission"; 
$route['admin/set_permission/(.*)']                                   =    "admin/C_admin/setPermission/$1*"; 
$route['admin/provider_list']                                                =    "admin/C_admin/providerList"; 
$route['admin/add_edit_provider']                                     =    "admin/C_admin/addEditProvider"; 
$route['admin/add_edit_provider/(.*)']                             =    "admin/C_admin/addEditProvider/$1*";

$route['admin/article_list']                                                   =    "admin/C_admin/articleList"; 
$route['admin/add_edit_article']                                        =    "admin/C_admin/addEditArticle"; 
$route['admin/add_edit_article/(.*)']                                =    "admin/C_admin/addEditArticle/$1*";
$route['admin/article_type_list']                                        =    "admin/C_admin/articleTypeList"; 
$route['admin/add_edit_article_type']                             =    "admin/C_admin/addEditArticleType"; 
$route['admin/add_edit_article_type/(.*)']                     =    "admin/C_admin/addEditArticleType/$1*";
$route['admin/change_password']                                    =    "admin/C_admin/changePassword"; 
$route['admin/user_report']                                               =    "admin/C_admin/userReport"; 
$route['admin/user_report_export']                                 =    "admin/C_admin/userReportExport"; 
$route['admin/provider_report']                                        =    "admin/C_admin/providerReport"; 
$route['admin/service_type_report']                                 =    "admin/C_admin/serviceTypeReport";  
$route['admin/testimonial_list']                                          =    "admin/C_admin/testimonialList"; 
$route['admin/add_edit_testimonial']                             =    "admin/C_admin/addEditTestimonial"; 
$route['admin/add_edit_testimonial/(.*)']                     =    "admin/C_admin/addEditTestimonial/$1*";
$route['admin/send_request']                                          =    "admin/C_admin/sendRequest";
 $route['admin/send_request/(.*)']                                  =    "admin/C_admin/sendRequest/$1*";
 
 $route['admin/job_request_report']                              =    "admin/C_admin/jobRequestReport";
 $route['admin/job_request_report/(.*)']                       =    "admin/C_admin/jobRequestReport/$1*";
 
 $route['admin/view_provider_jobs']                              =    "admin/C_admin/viewProviderJobs";
 $route['admin/view_provider_jobs/(.*)']                       =    "admin/C_admin/viewProviderJobs/$1*";
 $route['admin/view_provider_quotations']                              =    "admin/C_admin/viewProviderQuotations";
 $route['admin/view_provider_quotations/(.*)']                       =    "admin/C_admin/viewProviderQuotations/$1*";
 
 
 $route['admin/quotation_list']                                         =    "admin/C_admin/quotataionList";
 $route['admin/quotation_list/(.*)']                                 =    "admin/C_admin/quotataionList/$1*";
 
 
 $route['admin/request_list']                                         =    "admin/C_admin/requestList";
 $route['admin/request_list/(.*)']                                 =    "admin/C_admin/requestList/$1*";
 $route['admin/view_user_jobs']                              =    "admin/C_admin/viewUserJobs";
 $route['admin/view_user_jobs/(.*)']                       =    "admin/C_admin/viewUserJobs/$1*";
 $route['admin/view_user_quotations']                              =    "admin/C_admin/viewUserQuotations";
 $route['admin/view_user_quotations/(.*)']                       =    "admin/C_admin/viewUserQuotations/$1*";
 
  $route['admin/add_edit_package']                              =    "admin/C_admin/addEditPackages";
 $route['admin/add_edit_package/(.*)']                       =    "admin/C_admin/addEditPackages/$1*";
 
 $route['admin/package_list']                              =    "admin/C_admin/listPackages";
 $route['admin/package_list/(.*)']                       =    "admin/C_admin/listPackages/$1*";
 
 $route['admin/aasign_package']                              =    "admin/C_admin/assignPackage";
 $route['admin/aasign_package/(.*)']                       =    "admin/C_admin/assignPackage/$1*";
 
 $route['admin/update_request']                              =    "admin/C_admin/updateRequest";
 $route['admin/update_request/(.*)']                      =    "admin/C_admin/updateRequest/$1*";
 
 $route['admin/add_edit_banner']                              =    "admin/C_admin/addEditBanner";
 $route['admin/add_edit_banner/(.*)']                      =    "admin/C_admin/addEditBanner/$1*";
 
 $route['admin/banner_list']                              =    "admin/C_admin/bannerList";
 $route['admin/banner_list/(.*)']                      =    "admin/C_admin/bannerList/$1*";
 $route['provider_reg']                               =    "website/User/loadProviderRegistrationForm";
 $route['provider_reg/(.*)']                      =    "website/User/loadProviderRegistrationForm/$1*";
 
 $route['request']                               =    "website/Request/loadRequestForm";
 $route['request/(.*)']                      =    "website/Request/loadRequestForm/$1*";
 
 $route['how_itworks']                       =    "Welcome/loadHowIsItWork";
 $route['careers']                       =    "Welcome/loadCareers";
 $route['aboutus']                       =    "Welcome/loadAboutUs";
 
 $route['myaccount']                       =    "website/User/myaccount";
 $route['forgot_password']                       =    "website/User/forgotPassword";
 $route['reset_password']                       =    "website/User/resetPassword";
 $route['reset_password/(.*)']                      =    "website/User/resetPassword/$1*";
 $route['admin/web_basic']                      =    "admin/C_admin/websiteBasic";
 $route['articles']                       =    "Welcome/loadArticles";
 $route['articles/(.*)']                      =    "Welcome/loadArticles/$1*";
 
 $route['services_list']                       =    "Welcome/loadServices";
 $route['services_list/(.*)']                      =    "Welcome/loadServices/$1*";
 
//  $route['admin/add_faq']                              =    "admin/C_admin/addEditFaq";
//  $route['admin/add_faq/(.*)']                         =    "admin/C_admin/addEditFaq/$1*";
 
//   $route['admin/faq_list']                              =    "admin/C_admin/listFaq";
  $route['admin/rating_list']                           =    "admin/C_admin/loadRatingList";
  
  $route['admin/home_page_labels']                      =    "admin/C_admin/homePageLabels";
  $route['contact']                      =    "Welcome/contact";
  
  $route['sub_services']                 = "Welcome/subServices";
  $route['sub_services/(.*)']            = "Welcome/subServices/$1";
  
  $route['booking_details/(.*)']    =    "website/User/booking_details/$1";
  $route['all_services']            =    "website/Services/services_list";
  
  $route['admin/faq_list']			=	"admin/C_admin/faq_list";
  $route['admin/add_faq']			=	"admin/C_admin/add_edit_faq";
  $route['admin/add_faq/(.*)']		=	"admin/C_admin/add_edit_faq/$1";
  
  $route['admin/app_slider']			 = "admin/C_admin/appSlider";
  $route['admin/add_edit_slider']		 = "admin/C_admin/addEditSlider";
  $route['admin/add_edit_slider/(.*)']   = "admin/C_admin/addEditSlider/$1";
  
  $route['admin/list_coupon']         = "admin/C_admin/listCoupon";
  $route['admin/add_edit_coupon']     = "admin/C_admin/addEditCoupon";
  $route['admin/add_edit_coupon/(.*)']     = "admin/C_admin/addEditCoupon/$1";
  
  $route['staffs-list/(.*)']     = "admin/C_admin/staffs_list/$1";
  
  $route['staffs-list/(.*)']     = "admin/C_admin/staffs_list/$1";
  $route['admin/add_edit_staff/(:any)']         = "admin/C_admin/addEditStaff/$1";
  $route['admin/add_edit_staff/(:any)/(:any)']  = "admin/C_admin/addEditStaff/$1/$2";
  
  $route['vendor-login']            = "Welcome/vendorLogin";

  $route['admin/manage_wallet/(.*)']                                     =    "admin/C_admin/manageWallet/$1*";
  
  $route['thankyou/(.*)']           = "Welcome/paymentSuccess/$1";
  $route['failure/(.*)']            = "Welcome/paymentFailed/$1";


  $route['admin/promotion_slider']       = "admin/C_admin/promotionSlider";
  $route['admin/add_edit_promotion_slider']    = "admin/C_admin/addEditpromotionSlider";
  $route['admin/add_edit_promotion_slider/(.*)']   = "admin/C_admin/addEditpromotionSlider/$1";