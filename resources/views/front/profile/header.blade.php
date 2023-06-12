<div class="col-sm-12">
	<div class="profile-bar" style="background-image:url('{{ auth()->user()->image_url }}');">
		<div class="contents">
			<br><br><br>
			<div class="avatar d-block m-auto avatar-lg avatar-rounded" style="background-image:url('{{ auth()->user()->image_url }}');"></div>

			<p class="profile-name text-white">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</p>
			<br>
			<div class="buttons">
				<ul>
					<li>
						<a href="{{ route('front.profile') }}"><i class="fa fa-user-circle-o"></i><span> My Profile</span></a>
					</li>
					<li>
						<a href="{{ route('front.profile.my_ads') }}"><i class="fa fa-adn"></i><span> My Ads</span></a>
					</li>
					{{-- <li>
						<a href="{{ route('front.profile.my_bid') }}"><i class="fa fa-dollar"></i><span> My Bid</span></a>
					</li> --}}
					<li>
						<a href="{{ route('front.nricard') }}"><i class="fa fa-address-card-o"></i><span> NRI's Card</span></a>
					</li>
					<li>
						<a href="{{ route('front.profile_edit') }}">
							<i class="fa fa-cog"></i><span> Edit Profile</span>
						</a>
					</li>
					<li>
						<a href="{{ route('logout') }}" onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
							<i class="fa fa-lock"></i><span> Logout</span>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>