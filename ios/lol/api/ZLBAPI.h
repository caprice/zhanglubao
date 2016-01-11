//
//  ZLBAPI.h
//  lol
//
//  Created by Rocks on 15/8/24.
//  Copyright (c) 2015年 Zhanglubao.com. All rights reserved.
//

#ifndef lol_ZLBAPI_h
#define lol_ZLBAPI_h

#define api_domain              @"http://api.lol.zhanglubao.com/v1/"
//Home
#define home_index_index        @"index.php?m=Home&c=Index&a=index"
#define home_fresh_video        @"index.php?m=Home&c=List&a=fresh&"
#define home_comm_video         @"index.php?m=Home&c=List&a=category&id=2&"
#define home_master_video       @"index.php?m=Home&c=List&a=category&id=1&"
#define home_album_video        @"index.php?m=Home&c=List&a=category&id=4&"
#define home_match_video        @"index.php?m=Home&c=List&a=category&id=3&"
#define home_owner_video        @"index.php?m=Home&c=List&a=category&id=5&"
#define home_other_video        @"index.php?m=Home&c=List&a=category&id=6&"

//top
#define top_day_video           @"index.php?m=Top&c=List&a=day&"
#define top_week_video          @"index.php?m=Top&c=List&a=week&"
#define top_month_video         @"index.php?m=Top&c=List&a=month&"
#define top_all_video           @"index.php?m=Top&c=List&a=all&"


//user
#define cate_home_index         @"index.php?m=Category&c=Index&a=index"
#define cate_pro_user           @"index.php?m=Category&c=List&a=user&id=2&"
#define cate_comm_user          @"index.php?m=Category&c=List&a=user&id=3&"
#define cate_master_user        @"index.php?m=Category&c=List&a=user&id=4&"
#define cate_match_user         @"index.php?m=Category&c=List&a=user&id=5&"
#define cate_team_user          @"index.php?m=Category&c=List&a=user&id=6&"
#define cate_album_album        @"index.php?m=Category&c=List&a=album&"
#define cate_hero_hero          @"index.php?m=Category&c=List&a=hero&"
#define cate_user_hot           @"index.php?m=Category&c=List&a=hotuser&"

//search
#define search_index_index      @"index.php?m=Search&c=Index&a=index"

//video
#define video_video_detail      @"index.php?m=Video&c=Video&a=detail"
#define video_comment_list      @"index.php?m=Video&c=Comment&a=comments"
#define video_comment_add       @"index.php?m=Video&c=Comment&a=add"
#define video_user_list         @"index.php?m=Video&c=List&a=user&id="
#define video_album_list        @"index.php?m=Video&c=List&a=album&id="
#define video_hero_list         @"index.php?m=Video&c=List&a=hero&id="


//sniff
#define sniff_video_sniff       @"index.php?m=Sniff&c=Sniff&a=sniff&id="
#define sniff_video_download =  @"index.php?m=Sniff&c=Download&a=download"

//user
#define user_snyc_login         @"index.php?m=User&c=Sync&a=login"
#define user_snyc_logout        @"index.php?m=User&c=Sync&a=logout"
#define user_subscribe_isfollow @"index.php?m=User&c=Subscribe&a=isfollow"
#define user_subscribe_follow   @"index.php?m=User&c=Subscribe&a=follow"
#define user_subscribe_unfollow @"index.php?m=User&c=Subscribe&a=unfollow"

#define user_subscribe_video    @"index.php?m=User&c=Subscribe&a=subscribes"
#define user_my_fav             @"index.php?m=User&c=Fav&a=favs"
#define user_fav_url            @"index.php?m=User&c=Fav&a=fav"
#define user_unfav_url          @"index.php?m=User&c=Fav&a=unfav"

//search
#define search_video_url        @"index.php?m=Search&c=Search&a=video&keyword="
#define search_user_url         @"index.php?m=Search&c=Search&a=user&keyword="


#endif
