package com.zhanglubao.lol.network;

/**
 * Created by rocks on 15-5-31.
 */
public class QTUrl {
    public static   String API_TEST_DOMAIN = "http://192.168.31.233/";
    public static   String API_DOMAIN = "http://api.lol.zhanglubao.com/v1/";

    //Home
    public static String home_index_index = "index.php?m=Home&c=Index&a=index";
    public static String home_fresh_video = "index.php?m=Home&c=List&a=fresh&";
    public static String home_comm_video = "index.php?m=Home&c=List&a=category&id=2&";
    public static String home_master_video = "index.php?m=Home&c=List&a=category&id=1&";
    public static String home_album_video = "index.php?m=Home&c=List&a=category&id=4&";
    public static String home_match_video = "index.php?m=Home&c=List&a=category&id=3&";
    public static String home_owner_video = "index.php?m=Home&c=List&a=category&id=5&";
    public static String home_other_video = "index.php?m=Home&c=List&a=category&id=6&";

    //top
    public static String top_day_video = "index.php?m=Top&c=List&a=day&";
    public static String top_week_video = "index.php?m=Top&c=List&a=week&";
    public static String top_month_video = "index.php?m=Top&c=List&a=month&";
    public static String top_all_video = "index.php?m=Top&c=List&a=all&";


    //user
    public static String cate_home_index = "index.php?m=Category&c=Index&a=index";
    public static String cate_pro_user = "index.php?m=Category&c=List&a=user&id=2&";
    public static String cate_comm_user = "index.php?m=Category&c=List&a=user&id=3&";
    public static String cate_master_user = "index.php?m=Category&c=List&a=user&id=4&";
    public static String cate_match_user = "index.php?m=Category&c=List&a=user&id=5&";
    public static String cate_team_user = "index.php?m=Category&c=List&a=user&id=6&";
    public static String cate_album_album = "index.php?m=Category&c=List&a=album&";
    public static String cate_hero_hero = "index.php?m=Category&c=List&a=hero&";
    public static String cate_user_hot = "index.php?m=Category&c=List&a=hotuser&";

    //search
    public static String search_index_index = "index.php?m=Search&c=Index&a=index";

    //video
    public static String video_video_detail = "index.php?m=Video&c=Video&a=detail";
    public static String video_comment_list = "index.php?m=Video&c=Comment&a=comments";
    public static String video_comment_add = "index.php?m=Video&c=Comment&a=add";
    public static String video_user_list = "index.php?m=Video&c=List&a=user&id=";
    public static String video_album_list = "index.php?m=Video&c=List&a=album&id=";
    public static String video_hero_list = "index.php?m=Video&c=List&a=hero&id=";


    //sniff
    public static String sniff_video_sniff = "index.php?m=Sniff&c=Sniff&a=sniff&id=";
    public static String sniff_video_download = API_DOMAIN+"index.php?m=Sniff&c=Download&a=download";

    //user
    public static String user_snyc_login = "index.php?m=User&c=Sync&a=login";
    public static String user_snyc_logout = "index.php?m=User&c=Sync&a=logout";
    public static String user_subscribe_isfollow = "index.php?m=User&c=Subscribe&a=isfollow";
    public static String user_subscribe_follow = "index.php?m=User&c=Subscribe&a=follow";
    public static String user_subscribe_unfollow = "index.php?m=User&c=Subscribe&a=unfollow";

    public static String user_subscribe_video = "index.php?m=User&c=Subscribe&a=subscribes";
    public static String user_my_fav = "index.php?m=User&c=Fav&a=favs";
    public static String user_fav_url = "index.php?m=User&c=Fav&a=fav";
    public static String user_unfav_url = "index.php?m=User&c=Fav&a=unfav";

    //search
    public static String search_video_url = "index.php?m=Search&c=Search&a=video&keyword=";
    public static String search_user_url = "index.php?m=Search&c=Search&a=user&keyword=";

    public static  String getVideoFrom(int id)
    {
        return  "http://www.zhanglubao.com";
    }

    public static  String getVideoFrom(String id)
    {
        return  "http://www.zhanglubao.com";
    }

}
