package com.zhanglubao.lol.activity;

import android.view.View;
import android.widget.GridView;
import android.widget.TextView;

import com.alibaba.fastjson.JSON;
import com.loopj.android.http.TextHttpResponseHandler;
import com.zhanglubao.lol.R;
import com.zhanglubao.lol.adapter.SimpleAlbumAdapter;
import com.zhanglubao.lol.model.SimpleAlbumModel;
import com.zhanglubao.lol.network.QTApi;
import com.zhanglubao.lol.network.QTUrl;
import com.zhanglubao.lol.network.entity.SimpleAlbumListEntity;
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
 * Created by rocks on 15-6-9.
 */
@EActivity(R.layout.activity_album_grid)
public class AlbumGridActivity extends BaseActivity {

    @Extra("title")
    String title;
    @ViewById(R.id.loadingBar)
    View loadingBar;
    @ViewById(R.id.netWorkError)
    View netWorkErrorView;
    @ViewById(R.id.nav_title)
    TextView titleView;

    @ViewById(R.id.albumGird)
    PullToRefreshGridView albumGird;
    int page = 0;
    boolean isPull = false;

    List<SimpleAlbumModel> albums;
    SimpleAlbumAdapter albumAdapter;



    @AfterViews
    public void afterViews() {
        titleView.setText(title);
        albums = new ArrayList<SimpleAlbumModel>();
        albumGird.setOnRefreshListener(new PullToRefreshBase.OnRefreshListener2<GridView>() {
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
        albumAdapter = new SimpleAlbumAdapter(this, albums);
        albumGird.setAdapter(albumAdapter);
        getData(page);
    }

    public void getData(int page) {
        if (!isPull) {
            loadingBar.setVisibility(View.VISIBLE);
        }
        QTApi.getUrlPage(QTUrl.cate_album_album, page, new TextHttpResponseHandler() {


            @Override
            public void onSuccess(int i, Header[] headers, String response) {
                try {
                    SimpleAlbumListEntity simpleVideoListEntity = (SimpleAlbumListEntity) JSON.parseObject(response, SimpleAlbumListEntity.class);
                    recevieData(simpleVideoListEntity.getAlbums());

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
        albumGird.onRefreshComplete();
    }

    @UiThread
    public void recevieData(List<SimpleAlbumModel> albumModels) {
        if (albumModels == null) {

            albumGird.onRefreshComplete();
            return;
        }
        loadingBar.setVisibility(View.GONE);
        albumGird.onRefreshComplete();
        if (page == 0) {
            albums.clear();
        }
        albums.addAll(albumModels);
        albumAdapter.notifyDataSetChanged();
        albumGird.requestLayout();
    }
    @Click(R.id.nav_back_btn)
    public void backBtn() {
        finish();
    }
}