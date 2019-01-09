<div class="cal-row-fluid cal-row-head">
	<% _.each(days_name, function(name){ %>
		<div class="cal-cell1"><%= name %></div>
	<% }) %>
</div>
<div class="cal-month-box">
	<% for(i = 0; i < 6; i++) { %>
		<% if(cal.stop_cycling == true) break; %>
		<div class="cal-row-fluid cal-before-eventlist">
			<div class="cal-cell1 cal-cell" data-cal-row="-day1" data-day-id="<%= i %><%= day %>"><%= cal._day(i, day++) %></div>
			<div class="cal-cell1 cal-cell" data-cal-row="-day2" data-day-id="<%= i %><%= day %>"><%= cal._day(i, day++) %></div>
			<div class="cal-cell1 cal-cell" data-cal-row="-day3" data-day-id="<%= i %><%= day %>"><%= cal._day(i, day++) %></div>
			<div class="cal-cell1 cal-cell" data-cal-row="-day4" data-day-id="<%= i %><%= day %>"><%= cal._day(i, day++) %></div>
			<div class="cal-cell1 cal-cell" data-cal-row="-day5" data-day-id="<%= i %><%= day %>"><%= cal._day(i, day++) %></div>
			<div class="cal-cell1 cal-cell" data-cal-row="-day6" data-day-id="<%= i %><%= day %>"><%= cal._day(i, day++) %></div>
			<div class="cal-cell1 cal-cell" data-cal-row="-day7" data-day-id="<%= i %><%= day %>"><%= cal._day(i, day++) %></div>
		</div>
	<% } %>
</div>
