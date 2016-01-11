package com.zhanglubao.lol.activity;

import android.annotation.SuppressLint;
import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.os.Build.VERSION_CODES;
import android.os.Bundle;
import android.support.v4.app.FragmentActivity;
import android.view.ViewGroup;
import android.view.Window;
import android.view.WindowManager;
import android.widget.LinearLayout;
import android.widget.LinearLayout.LayoutParams;
import android.widget.TextView;
import android.widget.Toast;

import com.alibaba.fastjson.JSON;
import com.loopj.android.http.RequestParams;
import com.loopj.android.http.TextHttpResponseHandler;
import com.nostra13.universalimageloader.core.ImageLoader;
import com.zhanglubao.lol.ZLBApplication;
import com.zhanglubao.lol.R;
import com.zhanglubao.lol.config.UserConfig;
import com.zhanglubao.lol.downloader.DownloadManager;
import com.zhanglubao.lol.evenbus.LoginSuccessEvent;
import com.zhanglubao.lol.evenbus.LogoutEvent;
import com.zhanglubao.lol.model.SimpleUserModel;
import com.zhanglubao.lol.network.QTApi;
import com.zhanglubao.lol.network.entity.LoginEntity;
import com.zhanglubao.lol.util.UmengUtil;
import com.zhanglubao.lol.view.user.LoginingDialog;
import com.umeng.analytics.MobclickAgent;
import com.umeng.fb.FeedbackAgent;
import com.umeng.message.PushAgent;
import com.umeng.message.UmengRegistrar;
import com.umeng.socialize.bean.SHARE_MEDIA;
import com.umeng.socialize.controller.UMServiceFactory;
import com.umeng.socialize.controller.UMSocialService;
import com.umeng.socialize.controller.listener.SocializeListeners;
import com.umeng.socialize.exception.SocializeException;
import com.umeng.socialize.sso.SinaSsoHandler;
import com.umeng.socialize.sso.UMQQSsoHandler;
import com.umeng.socialize.sso.UMSsoHandler;
import com.umeng.update.UmengUpdateAgent;

import org.apache.http.Header;

import java.lang.reflect.Field;
import java.util.Map;

import de.greenrobot.event.EventBus;

/**
 * Created by rocks on 14-11-24.
 */
public class BaseFragmentActivity extends FragmentActivity {
    FeedbackAgent fb;
    private PushAgent mPushAgent;
    UMSocialService loginController = UMServiceFactory.getUMSocialService("com.umeng.login");

    LoginingDialog loginingDialog;
    SimpleUserModel profile;
    String mogoID = "e6a3bf93c9ba47b78b618d5cdbb557b7";
    boolean isFull = true;
    //状态栏沉浸模式使用
    /*statusbar view*/
    private ViewGroup view;
    /*沉浸颜色*/
    private TextView textView;
    int defaultNavColor=0;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        DownloadManager.getInstance();
        if (!EventBus.getDefault().isRegistered(this)) {
            EventBus.getDefault().register(this);
        }
        loginingDialog = new LoginingDialog(this);
        if (isFull) {
            if (defaultNavColor!=0) {
                //沉浸模式功能代码
                initStatusbar(this, defaultNavColor);
            }else
            {
                initStatusbar(this, R.color.nav_background);
            }
        }
        String device_token = UmengRegistrar.getRegistrationId(this);
        UmengUpdateAgent.update(this);
        UmengUpdateAgent.silentUpdate(this);
        setUpUmeng();
    }


    /**
     * 沉浸模式状态栏初始化
     *
     * @param context 上下文
     * @param
     * @return
     */
    @SuppressLint("NewApi")
    public void initStatusbar(Context context, int statusbar_bg) {
        //4.4版本及以上可用
        if (android.os.Build.VERSION.SDK_INT >= VERSION_CODES.KITKAT) {
            // 状态栏沉浸效果
            Window window = ((Activity) context).getWindow();
            window.setFlags(WindowManager.LayoutParams.FLAG_TRANSLUCENT_STATUS,
                    WindowManager.LayoutParams.FLAG_TRANSLUCENT_STATUS);
            window.setFlags(
                    WindowManager.LayoutParams.FLAG_TRANSLUCENT_NAVIGATION,
                    WindowManager.LayoutParams.FLAG_TRANSLUCENT_NAVIGATION);
            //decorview实际上就是activity的外层容器，是一层framlayout
            view = (ViewGroup) ((Activity) context).getWindow().getDecorView();
            LinearLayout.LayoutParams lParams = new LinearLayout.LayoutParams(
                    LayoutParams.MATCH_PARENT, getStatusBarHeight());
            //textview是实际添加的状态栏view，颜色可以设置成纯色，也可以加上shape，添加gradient属性设置渐变色
            textView = new TextView(this);
            textView.setBackgroundResource(statusbar_bg);
            textView.setLayoutParams(lParams);
            view.addView(textView);
        }
    }

    /**
     * 获取状态栏高度
     *
     * @return
     */
    public int getStatusBarHeight() {
        Class<?> c = null;
        Object obj = null;
        Field field = null;
        int x = 0, statusBarHeight = 0;
        try {
            c = Class.forName("com.android.internal.R$dimen");
            obj = c.newInstance();
            field = c.getField("status_bar_height");
            x = Integer.parseInt(field.get(obj).toString());
            statusBarHeight = getResources().getDimensionPixelSize(x);
        } catch (Exception e1) {
            e1.printStackTrace();
        }
        return statusBarHeight;
    }

    /**
     * 如果项目中用到了slidingmenu,根据slidingmenu滑动百分比设置statusbar颜色：渐变色效果
     *
     * @param alpha
     */
    @SuppressLint("NewApi")
    public void changeStatusBarColor(float alpha) {
        //textview是slidingmenu关闭时显示的颜色
        //textview2是slidingmenu打开时显示的颜色
        textView.setAlpha(1 - alpha);

    }


    public void getProfile() {
        profile = UserConfig.getUser();
    }

    private void setUpUmeng() {
        fb = new FeedbackAgent(this);
        fb.sync();
        fb.openAudioFeedback();
        fb.openFeedbackPush();

        mPushAgent = PushAgent.getInstance(this);
        mPushAgent.enable();
        mPushAgent.onAppStart();

        new Thread(new Runnable() {
            @Override
            public void run() {
                boolean result = fb.updateUserInfo();
            }
        }).start();
    }

//    public void onEvent(VideoEvent event) {
//        SimpleVideoModel simpleVideoModel = event.getSimpleVideoModel();
//        Intent intent = new Intent(this, VideoDetailActivity_.class);
//        intent.putExtra("video", simpleVideoModel);
//        startActivity(intent);
//    }
//
//    public void onEvent(ListEvent list) {
//
//        Intent intent = new Intent(this, VideoGridActivity_.class);
//        intent.putExtra("title", list.getTitle());
//        intent.putExtra("url", list.getUrl());
//        startActivity(intent);
//    }

    @Override
    protected void onPause() {
        super.onPause();
        MobclickAgent.onPause(this);
    }

    @Override
    protected void onResume() {
        super.onResume();
        MobclickAgent.onResume(this);
    }


    @Override
    public void onDestroy() {
        super.onDestroy();

        EventBus.getDefault().unregister(this);
        ImageLoader.getInstance().stop();
    }


    @Override
    public void onLowMemory() {                    //android系统调用
        super.onLowMemory();
        System.gc();
    }


    public void logout(SHARE_MEDIA platform) {
        loginController.deleteOauth(this, platform,
                null);
    }


    public void loginQQ() {
        UMQQSsoHandler qqSsoHandler = new UMQQSsoHandler(this, UmengUtil.QQ_APP_ID,
                UmengUtil.QQ_APP_KEY);
        qqSsoHandler.addToSocialSDK();

        login(SHARE_MEDIA.QQ);


    }

    public void loginSina() {
        loginController.getConfig().setSsoHandler(new SinaSsoHandler());

        login(SHARE_MEDIA.SINA);

    }

    public void login(SHARE_MEDIA platform) {
        loginController.doOauthVerify(this, platform, new SocializeListeners.UMAuthListener() {
            @Override
            public void onStart(SHARE_MEDIA platform) {
                showLoginDialog();
            }

            @Override
            public void onError(SocializeException e, SHARE_MEDIA platform) {
                Toast.makeText(ZLBApplication.mContext, "授权错误", Toast.LENGTH_SHORT).show();
                dissMissDialog();
            }

            @Override
            public void onComplete(Bundle value, SHARE_MEDIA platform) {

                loginController.getPlatformInfo(ZLBApplication.mContext, platform, new PlatformListener(platform, value));


            }

            @Override
            public void onCancel(SHARE_MEDIA platform) {
                Toast.makeText(ZLBApplication.mContext, "授权取消", Toast.LENGTH_SHORT).show();
                dissMissDialog();
            }
        });
    }

    class PlatformListener implements SocializeListeners.UMDataListener {
        SHARE_MEDIA platform;
        Bundle bundle;

        public PlatformListener(SHARE_MEDIA platform, Bundle bundle) {
            this.platform = platform;
            this.bundle = bundle;
        }

        @Override
        public void onStart() {
            showLoginDialog();
        }

        @Override
        public void onComplete(int status, Map<String, Object> info) {
            if (status == 200 && info != null) {
                snycLogin(info, bundle, platform);

            } else {

                Toast.makeText(ZLBApplication.mContext, "发生错误：" + status, Toast.LENGTH_SHORT).show();
                dissMissDialog();
            }
        }
    }

    public void snycLogin(Map<String, Object> info, Bundle bundle, SHARE_MEDIA platform) {
        RequestParams requestParams = new RequestParams();
        if (platform == SHARE_MEDIA.QQ) {

            requestParams.add("openid", bundle.getString("openid"));
            requestParams.add("nickname", String.valueOf(info.get("screen_name")));
            requestParams.add("avatar", String.valueOf(info.get("profile_image_url")));
            requestParams.add("access_token", bundle.getString("access_token"));
            requestParams.add("type", "qq");

        } else if (platform == SHARE_MEDIA.SINA) {
            requestParams.add("openid", String.valueOf(info.get("uid")));
            requestParams.add("nickname", String.valueOf(info.get("screen_name")));
            requestParams.add("avatar", String.valueOf(info.get("profile_image_url")));
            requestParams.add("access_token", bundle.getString("access_token"));
            requestParams.add("type", "weibo");
        } else {
            loginError();
        }
        bind(requestParams);
    }

    public void bind(RequestParams params) {
        QTApi.bindAccount(params, new TextHttpResponseHandler() {
            @Override
            public void onSuccess(int i, Header[] headers, String response) {
                try {

                    LoginEntity loginEntity = (LoginEntity) JSON.parseObject(response, LoginEntity.class);

                    if (loginEntity.getUser() == null) {
                        loginError();

                    } else {
                        loginSuccess(loginEntity);
                    }

                } catch (Exception e) {

                    loginError();
                }
            }

            @Override
            public void onFailure(int i, Header[] headers, String response, Throwable throwable) {
                String error = response;
                loginError();
            }
        });
    }

    public void loginSuccess(LoginEntity loginEntity) {
        UserConfig.login(loginEntity.getUser());
        EventBus.getDefault().post(new LoginSuccessEvent(loginEntity.getUser()));
        dissMissDialog();
    }

    public void loginError() {
        dissMissDialog();
        Toast.makeText(ZLBApplication.mContext, "登陆失败", Toast.LENGTH_SHORT).show();
    }

    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        /**使用SSO授权必须添加如下代码 */
        UMSsoHandler ssoHandler = loginController.getConfig().getSsoHandler(requestCode);
        if (ssoHandler != null) {
            ssoHandler.authorizeCallBack(requestCode, resultCode, data);
        }
    }

    public void showLoginDialog() {
        if (loginingDialog != null && !loginingDialog.isShowing()) {
            loginingDialog.show();
        }
    }

    public void dissMissDialog() {
        if (loginingDialog != null && loginingDialog.isShowing()) {
            loginingDialog.dismiss();
        }
    }

    public void onEvent(LoginSuccessEvent event) {

        profile = event.getUser();

    }

    public void onEvent(LogoutEvent event) {

        QTApi.logout();
    }
}
