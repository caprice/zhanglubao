package com.zhanglubao.lol.activity;

import android.content.Intent;
import android.content.pm.ActivityInfo;
import android.content.res.Configuration;
import android.graphics.Bitmap;
import android.graphics.Rect;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.util.DisplayMetrics;
import android.view.Display;
import android.view.KeyEvent;
import android.view.View;
import android.view.WindowManager;
import android.widget.ImageView;
import android.widget.PopupWindow;
import android.widget.RelativeLayout;
import android.widget.ScrollView;
import android.widget.TextView;

import com.alibaba.fastjson.JSON;
import com.loopj.android.http.TextHttpResponseHandler;
import com.nostra13.universalimageloader.core.DisplayImageOptions;
import com.nostra13.universalimageloader.core.ImageLoader;
import com.nostra13.universalimageloader.core.display.RoundedBitmapDisplayer;
import com.zhanglubao.lol.ZLBApplication;
import com.zhanglubao.lol.R;
import com.zhanglubao.lol.adapter.SimpleCommentAdapter;
import com.zhanglubao.lol.adapter.SimpleVideoAdapter;
import com.zhanglubao.lol.config.UserConfig;
import com.zhanglubao.lol.downloader.DownloadManager;
import com.zhanglubao.lol.evenbus.CommentEvent;
import com.zhanglubao.lol.evenbus.FullScreenEvent;
import com.zhanglubao.lol.evenbus.ListEvent;
import com.zhanglubao.lol.evenbus.LoginSuccessEvent;
import com.zhanglubao.lol.evenbus.PopLoginEvent;
import com.zhanglubao.lol.evenbus.UnVideoFavEvent;
import com.zhanglubao.lol.evenbus.VideoBackEvent;
import com.zhanglubao.lol.evenbus.VideoFavEvent;
import com.zhanglubao.lol.evenbus.VideoShareEvent;
import com.zhanglubao.lol.model.CommentModel;
import com.zhanglubao.lol.model.SimpleUserModel;
import com.zhanglubao.lol.model.SimpleVideoModel;
import com.zhanglubao.lol.network.QTApi;
import com.zhanglubao.lol.network.QTUrl;
import com.zhanglubao.lol.network.entity.CommentListEntity;
import com.zhanglubao.lol.network.entity.VideoDetailEntity;
import com.zhanglubao.lol.util.DetailUtil;
import com.zhanglubao.lol.util.DeviceOrientationHelper;
import com.zhanglubao.lol.util.DeviceOrientationHelper.OrientationChangeCallback;
import com.zhanglubao.lol.util.Orientation;
import com.zhanglubao.lol.util.PlayerUtil;
import com.zhanglubao.lol.util.PreferenceUtil;
import com.zhanglubao.lol.util.UmengUtil;
import com.zhanglubao.lol.view.player.QTPlayerView;
import com.zhanglubao.lol.view.video.CommentDialog;
import com.zhanglubao.lol.view.video.NoScrollGridView;
import com.zhanglubao.lol.view.video.NoScrollListView;
import com.zhanglubao.lol.view.video.SubscribeView;
import com.zhanglubao.pulltorefresh.PullToRefreshBase;
import com.zhanglubao.pulltorefresh.PullToRefreshScrollView;
import com.umeng.socialize.bean.SHARE_MEDIA;
import com.umeng.socialize.controller.UMServiceFactory;
import com.umeng.socialize.controller.UMSocialService;
import com.umeng.socialize.facebook.controller.UMFacebookHandler;
import com.umeng.socialize.facebook.media.FaceBookShareContent;
import com.umeng.socialize.media.MailShareContent;
import com.umeng.socialize.media.QQShareContent;
import com.umeng.socialize.media.QZoneShareContent;
import com.umeng.socialize.media.SinaShareContent;
import com.umeng.socialize.media.SmsShareContent;
import com.umeng.socialize.media.TencentWbShareContent;
import com.umeng.socialize.media.TwitterShareContent;
import com.umeng.socialize.media.UMImage;
import com.umeng.socialize.sso.EmailHandler;
import com.umeng.socialize.sso.QZoneSsoHandler;
import com.umeng.socialize.sso.SinaSsoHandler;
import com.umeng.socialize.sso.SmsHandler;
import com.umeng.socialize.sso.UMQQSsoHandler;
import com.umeng.socialize.weixin.controller.UMWXHandler;
import com.umeng.socialize.weixin.media.CircleShareContent;
import com.umeng.socialize.weixin.media.WeiXinShareContent;

import org.androidannotations.annotations.AfterViews;
import org.androidannotations.annotations.Click;
import org.androidannotations.annotations.EActivity;
import org.androidannotations.annotations.Extra;
import org.androidannotations.annotations.ViewById;
import org.apache.http.Header;

import java.util.ArrayList;
import java.util.List;

import de.greenrobot.event.EventBus;


/**
 * Created by rocks on 15-6-2.
 */

@EActivity(R.layout.activity_video_detail)
public class VideoDetailActivity extends BasePlayerActivity implements OrientationChangeCallback {

    @Extra("video")
    SimpleVideoModel videoModel;
    @ViewById(R.id.widget_video_cover)
    ImageView coverImageView;


    @ViewById(R.id.loadingBar)
    View loadingBar;
    @ViewById(R.id.netWorkError)
    View netWorkErrorView;

    @ViewById(R.id.detail_video_avatar_image)
    ImageView avatarImageView;
    @ViewById(R.id.detail_video_user_name)
    TextView userNameTextView;

    @ViewById(R.id.detail_video_relates)
    NoScrollGridView videoGridView;

    @ViewById(R.id.video_view)
    QTPlayerView qtPlayerView;

    @ViewById(R.id.video_layout)
    View videoLayout;

    @ViewById(R.id.sub_content)
    View contentView;

    @ViewById(R.id.profile_avatar)
    ImageView profileAvatar;

    @ViewById(R.id.comment_count)
    TextView commentCountTextView;

    @ViewById(R.id.comment_list)
    NoScrollListView commentList;

    @ViewById(R.id.detail_scroll_view)
    PullToRefreshScrollView scrollView;
    @ViewById(R.id.subscribe)
    SubscribeView subscribeView;

    @ViewById(R.id.no_comments)
    View noCommentView;

    boolean isFav = false;


    private DeviceOrientationHelper orientationHelper;

    private DisplayImageOptions options;

    private DisplayImageOptions avataroptions;

    private DisplayImageOptions videosoptions;

    boolean isFullScreen = false;

    SimpleCommentAdapter commentAdapter;
    List<CommentModel> comments = new ArrayList<>();

    int page = 0;

    private CommentDialog addDialog;
    VideoDetailEntity detailEntity;

    //share
    final UMSocialService mController = UMServiceFactory.getUMSocialService("com.umeng.share");
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        isFull=false;
        super.onCreate(savedInstanceState);

    }
    @AfterViews
    public void afterView() {
        addShareConfig();
        setShareContent();

        options = new DisplayImageOptions.Builder()
                .showImageOnLoading(R.drawable.default_video_cover)
                .showImageForEmptyUri(R.drawable.default_video_cover)
                .showImageOnFail(R.drawable.default_video_cover)
                .cacheInMemory(true)
                .cacheOnDisk(true)
                .considerExifParams(true)
                .bitmapConfig(Bitmap.Config.RGB_565)
                .build();

        avataroptions = new DisplayImageOptions.Builder()
                .showImageOnLoading(R.drawable.default_user_round_avatar)
                .showImageForEmptyUri(R.drawable.default_user_round_avatar)
                .showImageOnFail(R.drawable.default_user_round_avatar)
                .displayer(new RoundedBitmapDisplayer(100))
                .cacheInMemory(true)
                .cacheOnDisk(true)
                .considerExifParams(true)
                .bitmapConfig(Bitmap.Config.RGB_565)
                .build();

        videosoptions = new DisplayImageOptions.Builder()
                .showImageOnLoading(R.drawable.default_video_cover)
                .showImageForEmptyUri(R.drawable.default_video_cover)
                .showImageOnFail(R.drawable.default_video_cover)
                .cacheInMemory(true)
                .cacheOnDisk(true)
                .considerExifParams(true)
                .displayer(new RoundedBitmapDisplayer(6))
                .bitmapConfig(Bitmap.Config.RGB_565)
                .build();
        ImageLoader.getInstance().displayImage(videoModel.getVideo_picture(),
                coverImageView, options);
        orientationHelper = new DeviceOrientationHelper(this, this);
        qtPlayerView.setVideoModel(videoModel);

        scrollView.setOnRefreshListener(new PullToRefreshBase.OnRefreshListener2<ScrollView>() {
            @Override
            public void onPullDownToRefresh(PullToRefreshBase<ScrollView> refreshView) {

            }

            @Override
            public void onPullUpToRefresh(PullToRefreshBase<ScrollView> refreshView) {
                getMoreComments();
            }
        });
        setUpProfile();
        getData();

    }


    public void getData() {

        loadingBar.setVisibility(View.VISIBLE);
        QTApi.getVideoDetail(videoModel.getId(), new TextHttpResponseHandler() {
            @Override
            public void onFailure(int i, Header[] headers, String response, Throwable throwable) {

                receiveMoreError(response);
            }

            @Override
            public void onSuccess(int i, Header[] headers, String response) {
                try {
                    detailEntity = (VideoDetailEntity) JSON.parseObject(response, VideoDetailEntity.class);
                    receiveData(detailEntity);
                } catch (Exception e) {
                    receiveMoreError(response);
                }
            }
        });
    }

    public void receiveMoreError(String response) {

        String result = response;
        System.out.print(response);

    }

    private void receiveData(VideoDetailEntity videoDetail) {

        SimpleVideoAdapter simpleVideoAdapter = new SimpleVideoAdapter(this, videoDetail.getRelates());
        videoGridView.setAdapter(simpleVideoAdapter);
        userNameTextView.setText(videoDetail.getVideo().getUser().getNickname());


        simpleVideoAdapter.notifyDataSetChanged();

        subscribeView.setUid(videoDetail.getVideo().getUser().getUid());

        commentList.requestLayout();
        ImageLoader.getInstance().displayImage(videoDetail.getVideo().getUser().getAvatar(),
                avatarImageView, avataroptions);
        if (videoDetail.getVideo().getComment_count() > 0) {
            commentCountTextView.setText(String.format(getString(R.string.video_page_comment_count), videoDetail.getVideo().getComment_count()));
        } else {
            commentCountTextView.setText("");
        }

        if (videoDetail.getVideo().getComment_count() < 10) {
            scrollView.setMode(PullToRefreshBase.Mode.DISABLED);
        }
        netWorkErrorView.setVisibility(View.GONE);
        loadingBar.setVisibility(View.GONE);
        comments.clear();
        comments = videoDetail.getComments();
        if (comments == null) {
            noCommentView.setVisibility(View.VISIBLE);
            return;
        }
        if (comments.size() > 0) {
            noCommentView.setVisibility(View.GONE);
        }
        if (comments.size() > 10) {
            scrollView.setMode(PullToRefreshBase.Mode.PULL_FROM_END);
        }
        if (comments.size() > 0) {
            commentAdapter = new SimpleCommentAdapter(comments, this);
            commentList.setAdapter(commentAdapter);
        }
        if (comments == null || comments.size() == 0) {
            noCommentView.setVisibility(View.VISIBLE);
        }

    }

    @Override
    protected void onNewIntent(Intent intent) {
        super.onNewIntent(intent);
        videoModel = (SimpleVideoModel) intent.getSerializableExtra("video");
        ImageLoader.getInstance().displayImage(videoModel.getVideo_picture(),
                coverImageView, options);

        qtPlayerView.setVideoModel(videoModel);
        getData();
    }


    @Override
    protected void onResume() {
        super.onResume();
        if (orientationHelper != null) {
            orientationHelper.enableListener();
        }

        Display localDisplay;
        int left;
        int right;
        int bottom;
        int top;
        int height;
        int width;
        localDisplay = getWindowManager().getDefaultDisplay();
        DisplayMetrics localDisplayMetrics1 = new DisplayMetrics();
        localDisplay.getMetrics(localDisplayMetrics1);
        Rect localRect = new Rect();
        getWindow().getDecorView().getWindowVisibleDisplayFrame(localRect);
        left = localRect.left;
        right = localRect.right;
        bottom = localRect.bottom;
        top = localRect.top;
        height = localDisplayMetrics1.heightPixels;
        width = localDisplayMetrics1.widthPixels;

        DetailUtil.writePortScreen(0, top, 0, 0, height, width);
        DetailUtil.writeLandScreen(0, top, 0, 0, width, height);
    }

    @Override
    public void onDestroy() {
        super.onDestroy();

        PreferenceUtil.setBoolean("video_lock", false);
        if (orientationHelper != null) {
            orientationHelper.disableListener();
            orientationHelper.setCallback(null);
            orientationHelper = null;
        }


    }


    public void goFullScreen(boolean direction) {
        if (null != qtPlayerView) {
            onFullscreenListener();
            isFullScreen = true;
            setPlayerFullScreen(direction);
        }
    }


    public void setPlayerFullScreen(boolean direction) {
        if (qtPlayerView == null)
            return;
        if (direction) {
            if (!PreferenceUtil.getBoolean(
                    "video_lock")) {
                setRequestedOrientation(ActivityInfo.SCREEN_ORIENTATION_SENSOR_LANDSCAPE);
            } else {
                setRequestedOrientation(ActivityInfo.SCREEN_ORIENTATION_LANDSCAPE);
            }
        } else {
            if (!PreferenceUtil.getBoolean("video_lock")) {
                setRequestedOrientation(ActivityInfo.SCREEN_ORIENTATION_SENSOR);
            } else {
                setRequestedOrientation(ActivityInfo.SCREEN_ORIENTATION_REVERSE_LANDSCAPE);
            }
        }


        isFullScreen = true;


        // 这里把他修改成为fillpearent
        runOnUiThread(new Runnable() {

            @Override
            public void run() {
                getWindow().setFlags(
                        WindowManager.LayoutParams.FLAG_FULLSCREEN,
                        WindowManager.LayoutParams.FLAG_FULLSCREEN);
            }
        });
    }


    public void goSmall() {
        onSmallscreenListener();
        isFullScreen = false;
        setPlayerSmall(true);

    }


    private void setPlayerSmall(boolean setRequsetOreitation) {            //-------》内部使用
        isFullScreen = false;
        setRequestedOrientation(ActivityInfo.SCREEN_ORIENTATION_PORTRAIT);
        getWindow().clearFlags(
                WindowManager.LayoutParams.FLAG_FULLSCREEN);


    }


    private boolean isLand() {
        Display getOrient = getWindowManager().getDefaultDisplay();
        return getOrient.getWidth() > getOrient.getHeight();
    }

    protected void changeConfiguration(Configuration newConfig) {
        super.onConfigurationChanged(newConfig);

    }

    @Override
    public void land2Port() {
        if (PreferenceUtil.getBoolean("video_lock")) {
            return;
        }
        if (!PreferenceUtil.getBoolean("video_lock")) {
            setRequestedOrientation(ActivityInfo.SCREEN_ORIENTATION_SENSOR_PORTRAIT);
        }
        goSmall();
    }

    @Override
    public void port2Land() {
        if (PreferenceUtil.getBoolean("video_lock")) {
            return;
        }
        if (PreferenceUtil.getBoolean("video_lock")) {
            setRequestedOrientation(ActivityInfo.SCREEN_ORIENTATION_LANDSCAPE);
        } else {
            layoutHandler.removeCallbacksAndMessages(null);
            setRequestedOrientation(ActivityInfo.SCREEN_ORIENTATION_SENSOR);
        }
        goFullScreen(true);
    }

    @Override
    public void reverseLand() {
        if (PreferenceUtil.getBoolean("video_lock")) {
            return;
        }
        if (!PreferenceUtil.getBoolean("video_lock")) {
            layoutHandler.removeCallbacksAndMessages(null);
            setRequestedOrientation(ActivityInfo.SCREEN_ORIENTATION_SENSOR);
        } else {
            setRequestedOrientation(ActivityInfo.SCREEN_ORIENTATION_REVERSE_LANDSCAPE);
        }
        goFullScreen(false);

    }

    @Override
    public void reversePort() {
        if (PreferenceUtil.getBoolean("video_lock")) {
            return;
        }
        setRequestedOrientation(ActivityInfo.SCREEN_ORIENTATION_PORTRAIT);
        goSmall();
    }

    @Override
    public void onFullScreenPlayComplete() {


    }

    private final int GET_LAND_PARAMS = 800;                            //------>内部使用
    private final int GET_PORT_PARAMS = 801;
    private Handler layoutHandler = new Handler() {
        @Override
        public void handleMessage(Message msg) {
            switch (msg.what) {
                case GET_LAND_PARAMS: {
                    getWindow().clearFlags(
                            WindowManager.LayoutParams.FLAG_FULLSCREEN);

                    changeConfiguration(new Configuration());
                    if (null != qtPlayerView)
                        qtPlayerView.currentOriention = Orientation.LAND;
                    break;
                }
                case GET_PORT_PARAMS: {
                    getWindow().clearFlags(
                            WindowManager.LayoutParams.FLAG_FULLSCREEN);

                    if (qtPlayerView != null) {
                        getWindow().setFlags(
                                WindowManager.LayoutParams.FLAG_FULLSCREEN,
                                WindowManager.LayoutParams.FLAG_FULLSCREEN);
                        qtPlayerView.currentOriention = Orientation.LAND;
                        return;
                    }
                    setRequestedOrientation(ActivityInfo.SCREEN_ORIENTATION_PORTRAIT);

                    if (null != qtPlayerView)
                        qtPlayerView.currentOriention = Orientation.VERTICAL;
                    break;
                }
            }


        }

    };


    @Override
    public void onFullscreenListener() {

        // 这里把他修改成为fillpearent
        runOnUiThread(new Runnable() {

            @Override
            public void run() {
                contentView.setVisibility(View.GONE);
                videoLayout.setLayoutParams(new RelativeLayout.LayoutParams(-1, -1));
                handler.postDelayed(new fullScreenRun(), 400L);

            }
        });
    }

    @Override
    public void onSmallscreenListener() {

        // 这里把他修改成为fillpearent
        runOnUiThread(new Runnable() {

            @Override
            public void run() {
                contentView.setVisibility(View.VISIBLE);
                videoLayout.setLayoutParams(new RelativeLayout.LayoutParams(-1, (int) ZLBApplication.mContext.getResources().getDimension(R.dimen.video_layout_default_size)));
                handler.postDelayed(new fullScreenRun(), 400L);
            }
        });


    }

    Handler handler = new Handler();

    class fullScreenRun implements Runnable {

        @Override
        public void run() {
            qtPlayerView.setFullscreenBack();
        }
    }

    class smallScreenRun implements Runnable {
        @Override
        public void run() {
            qtPlayerView.setFullscreenBack();
        }
    }

    public void onEvent(FullScreenEvent event) {
        if (isFullScreen) {
            goSmall();
        } else {
            port2Land();
        }

    }

    public void onEvent(VideoBackEvent event) {

        if (isFullScreen) {
            goSmall();
        } else {
            super.onBackPressed();
        }

    }

    public boolean onKeyDown(int keyCode, KeyEvent event) {
        try {
            switch (keyCode) {
                case KeyEvent.KEYCODE_MENU:
                    // 取消长按menu键弹出键盘事
                    if (event.getRepeatCount() > 0) {
                        return true;
                    }
                    return isFullScreen;
                case KeyEvent.KEYCODE_BACK:
                    // 点击过快的取消操
                    if (event.getRepeatCount() > 0) {
                        return true;
                    }

                    if (isFullScreen) {
                        goSmall();
                        return true;
                    } else {
                        return super.onKeyDown(keyCode, event);
                    }


                case 125:
                    /** 有些手机载入中弹出popupwindow */
                    return true;
            }
        } catch (Exception e) {
            e.printStackTrace();
        }
        return super.onKeyDown(keyCode, event);
    }

    public void onEvent(LoginSuccessEvent event) {
        setUpProfile();
    }

    private void setUpProfile() {
        SimpleUserModel user = UserConfig.getUser();
        if (user == null) {
            return;
        }
        ImageLoader.getInstance().displayImage(user.getAvatar(),
                profileAvatar, avataroptions);
    }

    public void getMoreComments() {
        page++;
        QTApi.getVideoComment(videoModel.getId(), page, new TextHttpResponseHandler() {
            @Override
            public void onSuccess(int status, Header[] headers, String response) {

                try {
                    CommentListEntity commentListEntity = (CommentListEntity) JSON.parseObject(response, CommentListEntity.class);
                    receiveComments(commentListEntity);

                } catch (Exception e) {

                    receiveCommentError();
                }
            }

            @Override
            public void onFailure(int status, Header[] headers, String response, Throwable throwable) {

                String text = response;
                receiveCommentError();
            }
        });

    }

    public void receiveComments(CommentListEntity commentListEntity) {
        comments.addAll(commentListEntity.getComments());
        commentAdapter.notifyDataSetChanged();
        scrollView.onRefreshComplete();
        commentList.requestLayout();
        scrollView.requestLayout();
        if (commentListEntity.getComments() == null || commentListEntity.getComments().size() == 0) {
            scrollView.setMode(PullToRefreshBase.Mode.DISABLED);
        }
    }

    public void receiveCommentError() {
        scrollView.onRefreshComplete();
    }

    private Handler mHandler = new Handler() {

        @Override
        public void dispatchMessage(Message msg) {
            super.dispatchMessage(msg);
        }
    };


    @Click(R.id.detail_bottom_comment_bar_input)
    public void showCommentDialog() {
        if (UserConfig.getUser() != null) {
            this.addDialog = new CommentDialog(this, videoModel.getId(), this.mHandler, new SoftDissmiss(), 0);
            this.addDialog.show(null, null);
        } else {
            EventBus.getDefault().post(new PopLoginEvent());
        }
    }

    class SoftDissmiss
            implements PopupWindow.OnDismissListener {
        SoftDissmiss() {
        }

        public void onDismiss() {
            closedCommentDialog();
        }
    }

    private void closedCommentDialog() {
        if (this.addDialog != null && this.addDialog.isShowing()) {
            this.addDialog.dismiss();
            this.addDialog = null;
        }
    }

    @Override
    public boolean dispatchKeyEvent(KeyEvent event) {
        if (event.getKeyCode() == KeyEvent.KEYCODE_BACK) {
            closedCommentDialog();
        }
        return super.dispatchKeyEvent(event);

    }

    public void onEvent(CommentEvent commentEvent) {

        QTApi.addComment(commentEvent.getVideoid(), commentEvent.getContent(), new TextHttpResponseHandler() {
            @Override
            public void onFailure(int i, Header[] headers, String s, Throwable throwable) {

            }

            @Override
            public void onSuccess(int i, Header[] headers, String s) {

            }
        });

        if (detailEntity != null) {
            List<CommentModel> temps = comments;
            comments = new ArrayList<>();
            CommentModel commentModel = new CommentModel();
            commentModel.setUser(UserConfig.getUser());
            commentModel.setContent(commentEvent.getContent());
            commentModel.setUid(UserConfig.getUser().getUid());
            comments.add(commentModel);
            comments.addAll(temps);
            commentAdapter = new SimpleCommentAdapter(comments, this);
            commentList.setAdapter(commentAdapter);
        }
        if (comments.size() > 0) {
            noCommentView.setVisibility(View.GONE);
        }
        if (comments.size() > 10) {
            scrollView.setMode(PullToRefreshBase.Mode.PULL_FROM_END);
        }
    }

    @Click(R.id.detail_video_cache)
    public void videoCache() {
        DownloadManager downloadManager = DownloadManager.getInstance();
        downloadManager.createDownload(String.valueOf(videoModel.getId()), videoModel.getVideo_title(), videoModel.getVideo_picture(), null);
    }

    public void onEvent(VideoFavEvent event) {

        QTApi.fav(videoModel.getId(), new TextHttpResponseHandler() {
            @Override
            public void onFailure(int i, Header[] headers, String s, Throwable throwable) {

                PlayerUtil.showTips(R.string.fav_fail);

            }

            @Override
            public void onSuccess(int i, Header[] headers, String s) {
                PlayerUtil.showTips(R.string.fav_success);
            }
        });

    }

    public void onEvent(UnVideoFavEvent event) {
        String[] videoids = {videoModel.getId()};
        QTApi.unfav(videoids, new TextHttpResponseHandler() {
            @Override
            public void onFailure(int i, Header[] headers, String s, Throwable throwable) {

                PlayerUtil.showTips(R.string.unfav_fail);

            }

            @Override
            public void onSuccess(int i, Header[] headers, String s) {
                PlayerUtil.showTips(R.string.unfav_success);
            }
        });
    }



    public void onEvent(VideoShareEvent event) {
        mController.getConfig().setPlatforms(SHARE_MEDIA.QQ, SHARE_MEDIA.SINA, SHARE_MEDIA.WEIXIN, SHARE_MEDIA.WEIXIN_CIRCLE,
                SHARE_MEDIA.QZONE, SHARE_MEDIA.TWITTER, SHARE_MEDIA.SMS, SHARE_MEDIA.EMAIL
        );
        mController.openShare(this, false);
    }

    public void addShareConfig() {
        addWXPlatform();
        addQQQZonePlatform();
        addEmail();
        addSMS();
    }

    /**
     * @return
     * @功能描述 : 添加微信平台分享
     */
    private void addWXPlatform() {
        // 注意：在微信授权的时候，必须传递appSecret
        // wx967daebe835fbeac是你在微信开发平台注册应用的AppID, 这里需要替换成你注册的AppID
        String appId = UmengUtil.WX_APP_ID;
        String appSecret = UmengUtil.WX_APP_SEC;
        // 添加微信平台
        UMWXHandler wxHandler = new UMWXHandler(this, appId, appSecret);
        wxHandler.addToSocialSDK();

        // 支持微信朋友圈
        UMWXHandler wxCircleHandler = new UMWXHandler(this, appId, appSecret);
        wxCircleHandler.setToCircle(true);
        wxCircleHandler.addToSocialSDK();
    }

    /**
     * @return
     * @功能描述 : 添加QQ平台支持 QQ分享的内容， 包含四种类型， 即单纯的文字、图片、音乐、视频. 参数说明 : title, summary,
     * image url中必须至少设置一个, targetUrl必须设置,网页地址必须以"http://"开头 . title :
     * 要分享标题 summary : 要分享的文字概述 image url : 图片地址 [以上三个参数至少填写一个] targetUrl
     * : 用户点击该分享时跳转到的目标地址 [必填] ( 若不填写则默认设置为友盟主页 )
     */
    private void addQQQZonePlatform() {
        String appId = UmengUtil.QQ_APP_ID;
        String appKey = UmengUtil.QQ_APP_KEY;
        // 添加QQ支持, 并且设置QQ分享内容的target url
        UMQQSsoHandler qqSsoHandler = new UMQQSsoHandler(this,
                appId, appKey);
        qqSsoHandler.setTargetUrl(QTUrl.getVideoFrom(videoModel.getId()));
        qqSsoHandler.addToSocialSDK();

        // 添加QZone平台
        QZoneSsoHandler qZoneSsoHandler = new QZoneSsoHandler(this, appId, appKey);
        qZoneSsoHandler.addToSocialSDK();
    }

    /**
     * @throws
     * @Title: addFacebook
     * @Description:
     */
    private void addFacebook() {

        UMFacebookHandler mFacebookHandler = new UMFacebookHandler(this);
        mFacebookHandler.addToSocialSDK();
        FaceBookShareContent fbContent = new FaceBookShareContent();

        fbContent.setTitle(videoModel.getVideo_title());
        fbContent.setCaption(videoModel.getVideo_title());
        fbContent.setShareContent(videoModel.getVideo_title());
        fbContent.setTargetUrl(QTUrl.getVideoFrom(videoModel.getId()));
        mController.setShareMedia(fbContent);

    }

    /**
     * 添加短信平台</br>
     */
    private void addSMS() {
        // 添加短信
        SmsHandler smsHandler = new SmsHandler();
        smsHandler.addToSocialSDK();
    }

    /**
     * 添加Email平台</br>
     */
    private void addEmail() {
        // 添加email
        EmailHandler emailHandler = new EmailHandler();
        emailHandler.addToSocialSDK();
    }

    public void setShareContent() {

        String title = videoModel.getVideo_title();
        String picture = videoModel.getVideo_picture();
        String from = QTUrl.getVideoFrom(videoModel.getId());
        String content = videoModel.getVideo_title() + " " + from;

        // 配置SSO
        mController.getConfig().setSsoHandler(new SinaSsoHandler());

        QZoneSsoHandler qZoneSsoHandler = new QZoneSsoHandler(this,
                UmengUtil.QQ_APP_ID, UmengUtil.QQ_APP_KEY);
        qZoneSsoHandler.addToSocialSDK();
        mController.setShareContent(videoModel.getVideo_title() + " " + from);

        UMImage urlImage = new UMImage(this, videoModel.getVideo_picture());


        WeiXinShareContent weixinContent = new WeiXinShareContent();
        weixinContent
                .setShareContent(content);
        weixinContent.setTitle(title);
        weixinContent.setTargetUrl(from);
        weixinContent.setShareMedia(urlImage);
        mController.setShareMedia(weixinContent);

        // 设置朋友圈分享的内容
        CircleShareContent circleMedia = new CircleShareContent();
        circleMedia
                .setShareContent(content);
        circleMedia.setTitle(title);
        circleMedia.setShareMedia(urlImage);

        circleMedia.setTargetUrl(from);
        mController.setShareMedia(circleMedia);


        UMImage qzoneImage = new UMImage(this, picture);
        qzoneImage
                .setTargetUrl(picture);

        // 设置QQ空间分享内容
        QZoneShareContent qzone = new QZoneShareContent();
        qzone.setShareContent(content);
        qzone.setTargetUrl(from);
        qzone.setTitle(title);
        qzone.setShareMedia(urlImage);
        mController.setShareMedia(qzone);


        QQShareContent qqShareContent = new QQShareContent();
        qqShareContent.setShareContent(content);
        qqShareContent.setTitle(title);
        qqShareContent.setTargetUrl(from);
        qqShareContent.setShareImage(urlImage);
        mController.setShareMedia(qqShareContent);


        TencentWbShareContent tencent = new TencentWbShareContent();
        tencent.setShareContent(content);
        tencent.setTargetUrl(from);
        tencent.setShareImage(urlImage);
        // 设置tencent分享内容
        mController.setShareMedia(tencent);

        // 设置邮件分享内容， 如果需要分享图片则只支持本地图片
        MailShareContent mail = new MailShareContent();
        mail.setTitle(title);
        mail.setShareContent(content);
        // 设置tencent分享内容
        mController.setShareMedia(mail);

        // 设置短信分享内容
        SmsShareContent sms = new SmsShareContent();
        sms.setShareContent(content);
        // sms.setShareImage(urlImage);
        mController.setShareMedia(sms);

        SinaShareContent sinaContent = new SinaShareContent();
        sinaContent
                .setShareContent(content);
        sinaContent.setTargetUrl(from);
        sinaContent.setShareImage(urlImage);
        mController.setShareMedia(sinaContent);

        TwitterShareContent twitterShareContent = new TwitterShareContent();
        twitterShareContent
                .setShareContent(content);
        mController.setShareMedia(twitterShareContent);


    }
    @Click(R.id.user_btn)
    public  void userBtn()
    {
        Intent intent=new Intent(this,VideoGridActivity_.class);
        intent.putExtra("title",detailEntity.getVideo().getUser().getNickname());
        String url= QTUrl.video_user_list+detailEntity.getVideo().getUser().getUid();
        intent.putExtra("url", url);
        startActivity(intent);
    }



    public void onEvent(ListEvent list) {

        Intent intent = new Intent(this, VideoGridActivity_.class);
        intent.putExtra("title", list.getTitle());
        intent.putExtra("url", list.getUrl());
        startActivity(intent);
    }

}


