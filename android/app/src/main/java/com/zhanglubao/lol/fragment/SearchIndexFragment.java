package com.zhanglubao.lol.fragment;

import android.content.Intent;
import android.view.View;

import com.alibaba.fastjson.JSON;
import com.loopj.android.http.TextHttpResponseHandler;
import com.zhanglubao.lol.R;
import com.zhanglubao.lol.activity.SearchEntranceActivity_;
import com.zhanglubao.lol.activity.UserGridActivity_;
import com.zhanglubao.lol.activity.VideoGridActivity_;
import com.zhanglubao.lol.adapter.SimpleUserAdapter;
import com.zhanglubao.lol.adapter.SimpleVideoAdapter;
import com.zhanglubao.lol.network.QTApi;
import com.zhanglubao.lol.network.QTUrl;
import com.zhanglubao.lol.network.entity.SearchIndexEntity;
import com.zhanglubao.lol.view.video.NoScrollGridView;
import com.zhanglubao.pulltorefresh.PullToRefreshScrollView;

import org.androidannotations.annotations.AfterViews;
import org.androidannotations.annotations.Click;
import org.androidannotations.annotations.EFragment;
import org.androidannotations.annotations.UiThread;
import org.androidannotations.annotations.ViewById;
import org.apache.http.Header;

/**
 * Created by rocks on 14-11-26.
 */
@EFragment(R.layout.fragment_search_index)
public class SearchIndexFragment extends  BaseFragment{

    @ViewById(R.id.loadingBar)
    View loadingBar;
    @ViewById(R.id.netWorkError)
    View netWorkErrorView;
    @ViewById(R.id.searchScrollView)
    PullToRefreshScrollView scrollView;

    @ViewById(R.id.search_hot_video_grid)
    NoScrollGridView videoGrid;
    @ViewById(R.id.search_hot_users_grid)
    NoScrollGridView usersGrid;

    public static SearchIndexFragment newInstance() {
        SearchIndexFragment fragment = new SearchIndexFragment_();
        return fragment;
    }
    @AfterViews
    public void afterViews() {
        mPageName=SearchIndexFragment.class.getName();
        getData();

    }

    public void getData() {

        QTApi.getSearchIndex(new TextHttpResponseHandler() {
            @Override
            public void onSuccess(int status, Header[] headers, String response) {

                try {
                    SearchIndexEntity searchIndexEntity = (SearchIndexEntity) JSON.parseObject(response, SearchIndexEntity.class);
                    recevieData(searchIndexEntity);

                } catch (Exception e) {

                    receiveError();
                }
            }

            @Override
            public void onFailure(int status, Header[] headers, String response, Throwable throwable) {

                String text = response;
                receiveError();
            }
        });
    }

    public void receiveError() {
        netWorkErrorView.setVisibility(View.VISIBLE);
        scrollView.onRefreshComplete();
    }

    @UiThread
    public void recevieData(SearchIndexEntity searchIndexEntity) {

        loadingBar.setVisibility(View.GONE);
        scrollView.onRefreshComplete();
        usersGrid.setAdapter(new SimpleUserAdapter(getActivity(), searchIndexEntity.getUsers()));
        videoGrid.setAdapter(new SimpleVideoAdapter(getActivity(),searchIndexEntity.getVideos()));


    }

    @Click(R.id.more_hot_video_btn)
    public  void moreHotVideo()
    {
        Intent intent=new Intent(getActivity(), VideoGridActivity_.class);
        intent.putExtra("title",getString(R.string.content_search_index_hot));
        intent.putExtra("url", QTUrl.top_day_video);
        startActivity(intent);
    }
    @Click(R.id.more_hot_user_btn)
    public  void moreHotUser()
    {
        Intent intent=new Intent(getActivity(), UserGridActivity_.class);
        intent.putExtra("title",getString(R.string.content_home_index_master_user));
        intent.putExtra("url",QTUrl.cate_user_hot);
        startActivity(intent);
    }

    @Click(R.id.search_btn)
    public  void search()
    {
        Intent intent=new Intent(getActivity(),SearchEntranceActivity_.class);
        startActivity(intent);
    }
}
