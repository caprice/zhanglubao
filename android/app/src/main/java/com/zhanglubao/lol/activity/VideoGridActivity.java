package com.zhanglubao.lol.activity;

import android.view.View;
import android.widget.GridView;
import android.widget.TextView;

import com.alibaba.fastjson.JSON;
import com.loopj.android.http.TextHttpResponseHandler;
import com.zhanglubao.lol.R;
import com.zhanglubao.lol.adapter.SimpleVideoAdapter;
import com.zhanglubao.lol.model.SimpleVideoModel;
import com.zhanglubao.lol.network.QTApi;
import com.zhanglubao.lol.network.entity.SimpleVideoListEntity;
import com.zhanglubao.pulltorefresh.PullToRefreshBase;
import com.zhanglubao.pulltorefresh.PullToRefreshGridView;

import org.androidannotations.annotations.AfterViews;
import org.androidannotations.annotations.Click;
import org.androidannotations.annotations.EActivity;
import org.androidannotations.annotations.Extra;
import org.androidannotations.annotations.UiThread;
import org.androidannotations.annotations.ViewById;
import org.apache.http.Header;

import java.util.ArrayList;
import java.util.List;

/**
 * Created by rocks on 14-11-25.
 */
@EActivity(R.layout.activity_video_grid)
public class VideoGridActivity extends BaseFragmentActivity{

    @Extra("title")
    String title;
    @Extra("url")
    String url;

    @ViewById(R.id.nav_title)
    TextView titleView;


    @ViewById(R.id.loadingBar)
    View loadingBar;
    @ViewById(R.id.netWorkError)
    View netWorkErrorView;


    @ViewById(R.id.video_gird)
    PullToRefreshGridView videoGird;

    int page = 0;
    boolean isPull = false;

    List<SimpleVideoModel> videos;
    SimpleVideoAdapter videoAdapter;


    @AfterViews
    public void afterViews()
    {
        titleView.setText(title);
        videos = new ArrayList<SimpleVideoModel>();
        videoGird.setOnRefreshListener(new PullToRefreshBase.OnRefreshListener2<GridView>() {
            @Override
            public void onPullDownToRefresh(PullToRefreshBase<GridView> refreshView) {
                page = 0;
                isPull = true;
                getData(page);
            }

            @Override
            public void onPullUpToRefresh(PullToRefreshBase<GridView> refreshView) {
                isPull = true;
                page++;
                getData(page);
            }
        });
        videoAdapter = new SimpleVideoAdapter(this, videos);
        videoGird.setAdapter(videoAdapter);
        getData(page);
    }

    public void getData(int page) {
        if (!isPull) {
            loadingBar.setVisibility(View.VISIBLE);
        }
        QTApi.getUrlPage(url, page, new TextHttpResponseHandler() {


            @Override
            public void onSuccess(int i, Header[] headers, String response) {
                try {
                    SimpleVideoListEntity simpleVideoListEntity = (SimpleVideoListEntity) JSON.parseObject(response, SimpleVideoListEntity.class);
                    recevieData(simpleVideoListEntity.getVideos());

                } catch (Exception e) {

                    receiveError();
                }
            }

            @Override
            public void onFailure(int i, Header[] headers, String response, Throwable throwable) {
                receiveError();
            }
        });
    }

    public void receiveError() {
        netWorkErrorView.setVisibility(View.VISIBLE);
        videoGird.onRefreshComplete();
    }

    @UiThread
    public void recevieData(List<SimpleVideoModel> videoModels) {
        if (videoModels==null&&page==0)
        {
            receiveError();
            videoGird.onRefreshComplete();
            return;
        }
        if (videoModels==null)
        {

            videoGird.onRefreshComplete();
            return;
        }
        loadingBar.setVisibility(View.GONE);
        videoGird.onRefreshComplete();
        if (page == 0) {
            videos.clear();
        }
        videos.addAll(videoModels);
        videoAdapter.notifyDataSetChanged();
        videoGird.requestLayout();
    }



    @Click(R.id.nav_back_btn)
    public  void backBtn()
    {
        this.finish();
    }


}
