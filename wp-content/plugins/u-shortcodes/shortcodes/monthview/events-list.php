<?php $parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' ); ?>
<!--<span id="cal-slide-tick" style="display: none"></span>-->
<div id="cal-slide-content" class="container cal-event-list">	
	<span class="close-button">
        <i class="fa fa-times"></i>
    </span>  
    <div class="slider-content">
       <?php	
	   		echo '<% 
            i=0;
            _.each(events, function(event) {        	
        	i=i+1;
        %>' ?>
            <div class="row slider-item">        	
                <div class="navagation-m">
                		<% if (events.length < 2) { %>
                            <span class="number-event-pd">
                            	<%if(event.posttype=="u_course") {%>
                                	<?php __("Course",'cactusthemes');?> <%=i%>/<%=events.length%>
                                <% } else {%>
    								<?php __("Event",'cactusthemes');?> <%=i%>/<%=events.length%>
                                <%}%>
    						</span> 
                        <% } else { %>
                            <span class="number-event">
                            	<%if(event.posttype=="u_course") {%>
                                	<?php __("Course",'cactusthemes');?> <%=i%>/<%=events.length%>
                                <% } else {%>
    								<?php __("Event",'cactusthemes');?> <%=i%>/<%=events.length%>
                                <%}%>                                
                            </span> 
                        <%}%>

                </div>
                
                <?php echo '<%if (event.picture !=null) {%>'?>
                    <div class="col-md-3 col-sm-3 img-content">
                        <a href="<?php echo "<%= event.url ? event.url : 'javascript:void(0)' %>" ?>" data-event-id="<%= event.id %>" data-event-class="<?php echo "<%= event['class'] %>"?> " class="event-item">
                            <img src="<%= event.picture %>" alt="" title="">
                            <div class="overlay-thumb"></div>
                        </a>
                    </div>
                    <div class="col-md-9 col-sm-9">                
                        <a href="<?php echo "<%= event.url ? event.url : 'javascript:void(0)' %> "?>" data-event-id="<%= event.id %>" data-event-class="<?php echo "<%= event['class'] %>"?>" class="event-item"><%= event.title %></a>
                        <span class="stm-time"><?php echo __("Time: ",'cactusthemes');?> <%if(event.posttype!="u_course") {%> <%= event.startDate %> / <%}%> <%= event.endDate %></span>
                        <span class="stm-location"><?php echo __("Location: ",'cactusthemes');?><%= event.location %></span>
                        <a href="<%= event.url ? event.url : 'javascript:void(0)' %>" class="event-btt"><?php echo __("BUY TICKET",'cactusthemes');?><%= event.buyticket %></a>
                    </div> 
                <?php echo " <%}else{%> "?>
                	<div class="col-md-12 col-sm-12">                
                        <a href="<?php echo "<%= event.url ? event.url : 'javascript:void(0)' %>"?>" data-event-id="<?php echo "<%= event.id %>"?>" data-event-class="<?php echo "<%= event['class'] %>"?>" class="event-item"><%= event.title %></a>
                        <span class="stm-time"><?php echo __("Time: ",'cactusthemes');?><%if(event.posttype!="u_course") {%> <%= event.startDate %> / <%}%> <%= event.endDate %></span>
                        <span class="stm-location"><?php echo __("Location: ",'cactusthemes');?><%= event.location %></span>
                        <a href="<%= event.url ? event.url : 'javascript:void(0)' %>" class="event-btt"><?php echo __("BUY TICKET",'cactusthemes');?><%= event.buyticket %></a>
                    </div> 
               <?php echo " <%}%> "?>                    
            </div>
        <?php echo "<%}) %>	"?>
	</div>
</div>
