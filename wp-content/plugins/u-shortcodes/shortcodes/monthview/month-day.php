<?php $parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' ); ?>
<div class="cal-month-day <%= cls %>" data-day-val="<%= data_day %>">
	<span class="cal-slide-tick"></span>
	<span class="pull-left" data-cal-date="<%= data_day %>" data-cal-view="day" data-toggle="tooltip" title="<%= tooltip %>"><%= day %></span>
	<% if (events.length > 0) { %>
		<div class="events-list" data-cal-start="<%= start %>" data-cal-end="<%= end %>">
			<?php echo '<%
            	iz=0;
             _.each(events, function(event) { 
             	iz=iz+1;
             %>' ?>
            	<?php echo ' <%if(event["class"]){%> '?>
					<a href="javascript:;" data-next-carousel="<?php echo '<%=iz%>'?>" data-event-id="<?php echo '<%= event.id %>'?>" data-event-class="<?php echo '<%= event["class"] %>' ?>" class="event" style="background:<?php echo '<%= event["class"] %>'?>" data-toggle="tooltip" title="<%= event.title %>" data-event-day-ck="<%= data_day %>"></a>
                <?php echo '<%}else{%>'?>
                 	<a href="javascript:;" data-next-carousel="<?php echo '<%=iz%>'?>" data-event-id="<?php echo '<%= event.id %>'?>" data-event-class="<?php echo '<%= event["class"] %>'?>" class="event event-default-red" data-toggle="tooltip" title="<%= event.title %>" data-event-day-ck="<%= data_day %>"></a>
                <%}%> 
                  	
			<?php echo '<% }); %> '?>
            	<a href="javascript:;" data-next-carousel="1" class="event event-default-black-hidden"></a>
		</div>
	<?php echo '<% } %>'?>
    <% if (events.length > 0) { %>
        <% if (events.length < 2) { %>
            <span class="number-events"><%=events.length%>
            <span class="uni-tex-event"><?php echo __(" Event",'cactusthemes');?></span> 
            <span class="uni-tex-course"><?php echo __(" Course",'cactusthemes');?></span>
        </span>
        <% } else { %>
        	<span class="number-events"><%=events.length%>
            	<span class="uni-tex-event"><?php echo __(" Events",'cactusthemes');?></span>
                <span class="uni-tex-course"><?php echo __(" Courses",'cactusthemes');?></span>
            </span>            
        <%}%>
    <% } %>
</div>
