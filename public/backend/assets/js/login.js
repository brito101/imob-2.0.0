$((function(){$.ajaxSetup({headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")}}),$('form[name="login"]').submit((function(e){e.preventDefault();const n=$(this),t=n.attr("action"),s=n.find('input[name="email"]').val(),i=n.find('input[name="password_check"]').val();$.post(t,{email:s,password:i},(function(e){e.message&&a(e.message,3),e.redirect&&(window.location.href=e.redirect)}),"json")}));var e=3;function a(e,a){var n=$(e);n.append("<div class='message_time'></div>"),n.find(".message_time").animate({width:"100%"},1e3*a,(function(){$(this).parents(".message").fadeOut(200)})),$(".ajax_response").append(n)}$(".ajax_response .message").each((function(n,t){a(t,e+=1)})),$(".ajax_response").on("click",".message",(function(e){$(this).effect("bounce").fadeOut(1)}))}));
