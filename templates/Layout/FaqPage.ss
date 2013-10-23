<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
	<article class="advancedfaq">
		<h1>$Title</h1>
		<div class="content">$Content</div>
		<% if FaqSections %>
			<% loop FaqSections %>
				<div><a href="#section-$ID-$Pos" class="anchor">$Title</a></div>
			<% end_loop %>
		<% end_if %>
		
		<% if FaqSections %>
			<% loop FaqSections %>
				<br/>
				<div class="section" id="section-$ID-$Pos">$Title</div>
				<% if Faqs %>
					<% loop Faqs %>
						<div class="question">$Question
						<% if FaqTags %>
							<% loop FaqTags %>
								<span class="green-round-btn" href="#Tag-$ID-$Top.Pos">$Title</span>
							<% end_loop %>
						<% end_if %>
						</div>
						<div class="answer">$Answer</div>
					<% end_loop %>
				<% end_if %>
			<% end_loop %>
		<% end_if %>
		
	</article>
</div>