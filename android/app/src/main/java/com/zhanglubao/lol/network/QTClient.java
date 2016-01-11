package com.zhanglubao.lol.network;

import com.loopj.android.http.AsyncHttpClient;
import com.loopj.android.http.AsyncHttpResponseHandler;
import com.loopj.android.http.PersistentCookieStore;
import com.loopj.android.http.RequestParams;
import com.zhanglubao.lol.ZLBApplication;

/**
 * Created by rocks on 15-5-28.
 */
public class QTClient {

    private static final String BASE_URL = QTUrl.API_DOMAIN;


    private static AsyncHttpClient client = new AsyncHttpClient();
    private static final PersistentCookieStore cookieStore = new PersistentCookieStore(
            ZLBApplication.mContext);



    public static void cancelAll() {
        client.cancelAllRequests(true);
    }
    public static void directGet(String url, RequestParams params,
                           AsyncHttpResponseHandler responseHandler) {
        client.get(url, params, responseHandler);
    }



    public static void get(String url, RequestParams params,
                           AsyncHttpResponseHandler responseHandler) {
        client.get(getAbsoluteUrl(url), params, responseHandler);
    }


    public static void post(String url, RequestParams params,
                            AsyncHttpResponseHandler responseHandler) {
        client.post(getAbsoluteUrl(url), params, responseHandler);
    }

    private static String getAbsoluteUrl(String relativeUrl) {
        client.setCookieStore(cookieStore);
        return BASE_URL + relativeUrl;
    }


    public static void clearCookie() {
        cookieStore.clear();
    }
}
