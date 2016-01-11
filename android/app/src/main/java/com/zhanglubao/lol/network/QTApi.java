package com.zhanglubao.lol.network;

import com.loopj.android.http.AsyncHttpResponseHandler;
import com.loopj.android.http.RequestParams;
import com.zhanglubao.lol.config.UserConfig;

/**
 * Created by rocks on 15-5-28.
 */
public class QTApi {

    public static void getHomeIndex(AsyncHttpResponseHandler responseHandler) {
        RequestParams requestParams = new RequestParams();
        QTClient.get(QTUrl.home_index_index, requestParams,
                responseHandler);

    }

    public static void getCateIndex(AsyncHttpResponseHandler responseHandler) {
        RequestParams requestParams = new RequestParams();
        QTClient.get(QTUrl.cate_home_index, requestParams,
                responseHandler);

    }

    public static void getSearchIndex(AsyncHttpResponseHandler responseHandler) {
        RequestParams requestParams = new RequestParams();
        QTClient.get(QTUrl.search_index_index, requestParams,
                responseHandler);

    }

    public static  void  getVideoDetail(String id,AsyncHttpResponseHandler responseHandler) {
        RequestParams requestParams = new RequestParams();
        requestParams.add("id",String.valueOf(id));
        QTClient.get(QTUrl.video_video_detail, requestParams,
                responseHandler);

    }

    public static void sniffContent(String url,AsyncHttpResponseHandler responseHandler)
    {

        RequestParams requestParams = new RequestParams();
        QTClient.get(url, requestParams,
                responseHandler);

    }

    public static  void sniff(String id,AsyncHttpResponseHandler responseHandler) {
        RequestParams requestParams = new RequestParams();
        requestParams.add("id",String.valueOf(id));
        QTClient.get(QTUrl.sniff_video_sniff, requestParams,
                responseHandler);

    }
    public static void  getUrlPage(String url,int page,AsyncHttpResponseHandler responseHandler) {
        url=url+"&page="+page;
        RequestParams requestParams = new RequestParams();
        QTClient.get(url, requestParams,
                responseHandler);

    }

    public static  void  getVideoComment(String id,int page,AsyncHttpResponseHandler responseHandler) {
        RequestParams requestParams = new RequestParams();
        requestParams.add("id",String.valueOf(id));
        requestParams.add("page",String.valueOf(page));
        QTClient.get(QTUrl.video_comment_list, requestParams,
                responseHandler);

    }

    public static void addComment(String videoid,String content,AsyncHttpResponseHandler responseHandler) {
        RequestParams requestParams = new RequestParams();
        requestParams.add("videoid",String.valueOf(videoid));
        requestParams.add("content",String.valueOf(content));

        QTClient.get(QTUrl.video_comment_add, requestParams,
                responseHandler);

    }

    public static void unfollow(String uid,AsyncHttpResponseHandler responseHandler) {
        RequestParams requestParams=new RequestParams();
        requestParams.add("uid",uid);
        QTClient.post(QTUrl.user_subscribe_unfollow, requestParams,
                responseHandler);

    }

    public static void follow(String uid,AsyncHttpResponseHandler responseHandler) {
        RequestParams requestParams=new RequestParams();
        requestParams.add("uid",uid);
        QTClient.post(QTUrl.user_subscribe_follow, requestParams,
                responseHandler);

    }

    public  static  void getIsFollow(String uid,AsyncHttpResponseHandler responseHandler) {
        RequestParams requestParams=new RequestParams();
        requestParams.add("uid",uid);
        QTClient.post(QTUrl.user_subscribe_isfollow, requestParams,
                responseHandler);

    }

    public static void  bindAccount(RequestParams requestParams,AsyncHttpResponseHandler responseHandler) {
        QTClient.post(QTUrl.user_snyc_login, requestParams,
                responseHandler);

    }

    public  static void logout()
    {
        UserConfig.logout();
        RequestParams requestParams=new RequestParams();
        QTClient.clearCookie();
        QTClient.get(QTUrl.user_snyc_logout, requestParams,
                null);

    }

    public static void fav(String videoid,AsyncHttpResponseHandler responseHandler) {
        RequestParams requestParams=new RequestParams();
        requestParams.add("videoid",videoid);
        QTClient.post(QTUrl.user_fav_url, requestParams,
                responseHandler);
    }


    public static void unfav(String[] videoids,AsyncHttpResponseHandler responseHandler) {
        RequestParams requestParams=new RequestParams();
        requestParams.put("videoids",videoids);
        QTClient.post(QTUrl.user_unfav_url, requestParams,
                responseHandler);
    }

}
