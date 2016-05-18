/* jshint ignore:start */ define( 'communitypage.templates.mustache', [], function() { 'use strict'; return {
    "CommunityPageSpecial_index" : '{{>pageHeader}}<div class="CommunityPageContainer"><div class="CommunityPageMainContent">{{#insightsModules.modules}}{{>insightsModule}}{{/insightsModules.modules}}</div><div class="WikiaRail">{{>contributorsModule}}{{>recentActivityModule}}</div></div>',"allAdmins" : '<ul class="community-page-user-based-list">{{#allAdminsList}}{{> userBasedList}}{{/allAdminsList}}{{^allAdminsList}}<div class="community-page-zero">{{noAdminText}}<a href="{{noAdminHref}}">{{noAdminContactText}}</a></div>{{/allAdminsList}}</ul>',"allMembers" : '<h2>{{allMembersHeaderText}}</h2><div class="community-page-all-contributors-legend">{{allContributorsLegend}}</div><ul class="reset top-contributors">{{#members}}<li class ="community-page-contributors-list-item {{#isCurrent}}community-page-current-contributor{{/isCurrent}}"><div class="avatar-container"><a data-tracking="all-members-user-avatar" href="{{profilePage}}">{{{avatar}}}</a></div><div class="community-page-contributor-details"><a data-tracking="all-members-user" href="{{profilePage}}">{{userName}}</a>{{#isAdmin}}<span class="community-page-subtle">{{admin}}</span>{{/isAdmin}}</div><div class="community-page-details">{{timeAgo}}</div></li>{{/members}}{{^members}}<div class="community-page-zero">{{noMembersText}}</div>{{/members}}{{#haveMoreMembers}}<li class="community-page-contributors-list-item"><div class="contributor-details"><a href="{{moreMembersLink}}">{{moreMembersText}}</a></div></li>{{/haveMoreMembers}}</ul>',"contributorsModule" : '<div class="module ContributorsModule">{{#topContributors}}{{>topContributors}}{{/topContributors}}{{#topAdminsData}}{{>topAdmins}}{{/topAdminsData}}{{#recentlyJoined}}{{>recentlyJoined}}{{/recentlyJoined}}</div>',"insightsModule" : '<section class="community-page-insights-module" data-tracking="community-page-insights-{{type}}"><h3 class="community-page-insights-module-header">{{title}}</h3><p class="community-page-insights-module-description">{{description}}</p>{{#fulllistlink}}<a class="community-page-insights-module-full-list-link" href="{{fulllistlink}}" data-tracking="view-full-list">{{insightsModules.messages.fulllist}} &rarr;</a>{{/fulllistlink}}<ul class="community-page-insights-module-list">{{#pages}}<li class="community-page-insights-module-list-item"><a class="community-page-insights-module-edit-icon" href="{{editlink}}" data-tracking="edit-icon"></a><span class="community-page-insights-module-article-data"><a href="{{link.articleurl}}" data-tracking="page-link">{{link.text}}</a><div class="community-page-insights-module-metadata">{{{metadataDetails}}} {{#pageviews}}&middot; {{pageviews}}{{/pageviews}}</div></span><a class="community-page-insights-module-edit-link" data-tracking="edit-link" href="{{editlink}}">{{edittext}}</a></li>{{/pages}}</ul></section>',"loadingError" : '<div>{{loadingError}}</div>',"modalHeader" : '<ul class="reset modal-nav"><li class="modal-nav-all"><a data-tracking="modal-tab-all" id="modalTabAll" class="modal-tab-link" href="#">{{allText}} <span id="allCount">{{allMembersCount}}</span></a></li><li class="modal-nav-admins"><a data-tracking="modal-tab-admins" id="modalTabAdmins" class="modal-tab-link" href="#">{{adminsText}} <span id="allAdminsCount">{{allAdminsCount}}</span></a></li><li class="modal-nav-leaderboard"><a data-tracking="modal-tab-leaderboard" id="modalTabLeaderboard" class="modal-tab-link" href="#">{{leaderboardText}}</a></li></ul>',"modalLoadingScreen" : '<div class="throbber-placeholder"></div>',"pageHeader" : '<div class="community-page-header {{#heroImageUrl}}community-page-header-cover" style="background-image: url({{heroImageUrl}});{{/heroImageUrl}}"><div class="community-page-header-content"><h1 class="community-page-heading">{{headerWelcomeMsg}}</h1></div></div><div class="community-page-admin-welcome-message"><p class="community-page-admin-welcome-message-text">{{adminWelcomeMsg}}</p></div>',"recentActivityModule" : '{{#recentActivityModule}}<div class="module RecentActivityModule"><h2 class="activity-heading">{{activityHeading}}</h2><ul class="community-page-user-based-list">{{#activity}}{{> userBasedList}}{{/activity}}</ul><a data-tracking="view-all-activity-link" href="{{moreActivityLink}}">{{moreActivityText}}</a></div>{{/recentActivityModule}}',"recentlyJoined" : '<section class="community-page-contributors-module-section community-page-recently-joined">{{#haveNewMembers}}<div class="members"><h2>{{recentlyJoinedHeaderText}}</h2>{{#members}}<div class="avatar-container"><a data-tracking="recently-joined-user-avatar" href="{{profilePage}}">{{{avatar}}}</a></div>{{/members}}</div>{{/haveNewMembers}}<span class="more-link"><a data-tracking="show-modal-all" href="#" id="viewAllMembers">{{allMembers}}</a></span></section>',"topAdmins" : '<section class="community-page-contributors-module-section top-admins"><h2>{{topAdminsHeaderText}}</h2><ul class="community-page-user-based-list">{{#topAdminsList}}{{> userBasedList}}{{/topAdminsList}}{{^topAdminsList}}<div class="community-page-zero">{{noAdminText}}<a href="{{noAdminHref}}">{{noAdminContactText}}</a></div>{{/topAdminsList}}</ul>{{#haveOtherAdmins}}<div class="community-page-contributors-list-item" id="openModalTopAdmins"><div class="avatar-container avatar-more">+{{otherAdminsCount}}</div><div class="community-page-contributor-details"><a href="">{{otherAdmins}}</a></div></div>{{/haveOtherAdmins}}</section>',"topContributors" : '<section class="community-page-contributors-module-section"><h2>{{topContribsHeaderText}}</h2><div class="user-details"><div class="avatar-container">{{{userAvatar}}}</div><div class="community-page-rank"><span>{{userRank}} <small>/ {{weeklyEditorCount}}</small></span><span class="community-page-subtle">{{yourRankText}}</span></div><div class="user-contrib-count"><span>{{userContribCount}}</span><span class="community-page-subtle">{{userContributionsText}}</span></div></div><ul class="community-page-user-based-list">{{#contributors}}{{> userBasedList}}{{/contributors}}{{^contributors}}<div class="community-page-zero">{{noContribsText}}</div>{{/contributors}}</ul></section>',"topContributorsModal" : '<h2>{{topContribsHeaderText}}</h2><div class="user-details"><div class="avatar-container">{{{userAvatar}}}</div><div class="community-page-rank"><span>{{userRank}} <small>/ {{weeklyEditorCount}}</small></span><span class="community-page-subtle">{{yourRankText}}</span></div><div class="user-contrib-count"><span>{{userContribCount}}</span><span class="community-page-subtle">{{userContributionsText}}</span></div></div><ul class="reset top-contributors">{{#contributors}}{{> userBasedList}}{{/contributors}}{{^contributors}}<div class="community-page-zero">{{noContribsText}}</div>{{/contributors}}</ul>',"userBasedList" : '<li class="community-page-user-based-list-item">{{#userAvatar}}<div class="avatar-container"><a data-tracking="user-avatar-link" href="{{userProfile}}">{{{userAvatar}}}</a></div>{{/userAvatar}}{{#count}}<div class="community-page-list-count">{{count}}.</div>{{/count}}<div class="community-page-user-based-list-main">{{{mainContent}}}{{#additionalContent}}<div class="community-page-user-based-list-additional">{{{additionalContent}}}</div>{{/additionalContent}}</div>{{#details}}<div class="community-page-user-based-list-details">{{details}}</div>{{/details}}</li>',
    "done": "true"
  }; }); /* jshint ignore:end */