package com.zhanglubao.lol.view.video;

import android.content.Context;
import android.util.AttributeSet;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.ProgressBar;
import android.widget.RelativeLayout;

import com.alibaba.fastjson.JSON;
import com.loopj.android.http.TextHttpResponseHandler;
import com.zhanglubao.lol.R;
import com.zhanglubao.lol.config.UserConfig;
import com.zhanglubao.lol.evenbus.PopLoginEvent;
import com.zhanglubao.lol.network.QTApi;
import com.zhanglubao.lol.network.entity.IsFollowEntity;

import org.apache.http.Header;

import de.greenrobot.event.EventBus;

/**
 * Created by rocks on 15-6-18.
 */
public class SubscribeView extends RelativeLayout {
    View alreadyView;
    View subscribeView;
    ProgressBar progressBar;
    String uid;

    public SubscribeView(Context context) {
        this(context, null);
    }

    public SubscribeView(Context context, AttributeSet attrs) {
        this(context, attrs, 0);
    }

    public SubscribeView(Context context, AttributeSet attrs, int defStyleAttr) {
        super(context, attrs, defStyleAttr);
        ((LayoutInflater) context
                .getSystemService(Context.LAYOUT_INFLATER_SERVICE)).inflate(
                R.layout.view_subscribe_view, this);

    }


    @Override
    protected void onFinishInflate() {
        super.onFinishInflate();
        alreadyView = findViewById(R.id.video_subscribe_already);
        subscribeView = findViewById(R.id.video_subscribe_btn);
        progressBar = (ProgressBar) findViewById(R.id.video_subscribe_progress);


        subscribeView.setOnClickListener(new OnClickListener() {
            @Override
            public void onClick(View v) {
                follow();
            }
        });
        alreadyView.setOnClickListener(new OnClickListener() {
            @Override
            public void onClick(View v) {
                unfollow();
            }
        });
    }

    public void setUid(String uid) {
        this.uid = uid;
        getData(uid);
    }

    private void getData(String uid) {

        if (UserConfig.getUser() == null) {
            progressBar.setVisibility(View.GONE);
            subscribeView.setVisibility(View.VISIBLE);
            return;
        } else {
            QTApi.getIsFollow(uid, new TextHttpResponseHandler() {
                @Override
                public void onFailure(int i, Header[] headers, String response, Throwable throwable) {

                    unfollowed();
                }

                @Override
                public void onSuccess(int i, Header[] headers, String response) {
                    try {
                        IsFollowEntity isFollowEntity = (IsFollowEntity) JSON.parseObject(response, IsFollowEntity.class);
                        if (isFollowEntity.getIsfollow()> 0) {
                            followed();
                        } else {
                            unfollowed();
                        }
                    } catch (Exception e) {
                        unfollowed();
                    }
                }
            });
        }
    }

    private void follow() {
        if (UserConfig.getUser() == null) {
            EventBus.getDefault().post(new PopLoginEvent());
            return;
        }
        QTApi.follow(uid, new TextHttpResponseHandler() {
            @Override
            public void onFailure(int i, Header[] headers, String s, Throwable throwable) {

            }

            @Override
            public void onSuccess(int i, Header[] headers, String s) {

            }
        });
        followed();
    }

    private void unfollow() {
        if (UserConfig.getUser() == null) {
            EventBus.getDefault().post(new PopLoginEvent());
            return;
        }
        QTApi.unfollow(uid, new TextHttpResponseHandler() {
            @Override
            public void onFailure(int i, Header[] headers, String s, Throwable throwable) {

            }

            @Override
            public void onSuccess(int i, Header[] headers, String s) {

            }
        });
        unfollowed();

    }

    private void unfollowed() {
        progressBar.setVisibility(View.GONE);
        subscribeView.setVisibility(View.VISIBLE);
        alreadyView.setVisibility(View.GONE);
    }

    private void followed() {
        progressBar.setVisibility(View.GONE);
        subscribeView.setVisibility(View.GONE);
        alreadyView.setVisibility(View.VISIBLE);
    }

}
