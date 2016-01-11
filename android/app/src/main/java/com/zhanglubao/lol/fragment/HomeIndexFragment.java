package com.zhanglubao.lol.fragment;

import android.content.Intent;
import android.view.View;
import android.widget.ScrollView;

import com.alibaba.fastjson.JSON;
import com.loopj.android.http.TextHttpResponseHandler;
import com.nostra13.universalimageloader.core.ImageLoader;
import com.nostra13.universalimageloader.core.listener.PauseOnScrollListener;
import com.zhanglubao.lol.R;
import com.zhanglubao.lol.activity.AlbumGridActivity_;
import com.zhanglubao.lol.activity.UserGridActivity_;
import com.zhanglubao.lol.activity.VideoGridActivity_;
import com.zhanglubao.lol.adapter.BannerPagerAdapter;
import com.zhanglubao.lol.adapter.SimpleAlbumAdapter;
import com.zhanglubao.lol.adapter.SimpleUserAdapter;
import com.zhanglubao.lol.adapter.SimpleVideoAdapter;
import com.zhanglubao.lol.model.SimpleVideoModel;
import com.zhanglubao.lol.network.QTApi;
import com.zhanglubao.lol.network.QTUrl;
import com.zhanglubao.lol.network.entity.HomeIndexEntity;
import com.zhanglubao.lol.network.entity.SimpleVideoListEntity;
import com.zhanglubao.lol.util.ConfigCache;
import com.zhanglubao.lol.view.banner.BannerAdView;
import com.zhanglubao.lol.view.video.NoScrollGridView;
import com.zhanglubao.pulltorefresh.PullToRefreshBase;
import com.zhanglubao.pulltorefresh.PullToRefreshScrollView;

import org.androidannotations.annotations.AfterViews;
import org.androidannotations.annotations.Click;
import org.androidannotations.annotations.EFragment;
import org.androidannotations.annotations.UiThread;
import org.androidannotations.annotations.ViewById;
import org.apache.http.Header;

import java.util.ArrayList;
import java.util.List;

/**
 * Created by rocks on 14-11-25.
 */
@EFragment(R.layout.fragment_home_index)
public class HomeIndexFragment extends BaseFragment {
    @ViewById(R.id.loadingBar)
    View loadingBar;
    @ViewById(R.id.netWorkError)
    View netWorkErrorView;
    @ViewById(R.id.homeScrollView)
    PullToRefreshScrollView scrollView;


    @ViewById(R.id.bannerAdView)
    BannerAdView bannerAdView;
    @ViewById(R.id.hot_video_grid)
    NoScrollGridView hotVideoGrid;

    @ViewById(R.id.comm_video_grid)
    NoScrollGridView commVideoGrid;
    @ViewById(R.id.comm_users_grid)
    NoScrollGridView commUsersGrid;


    @ViewById(R.id.master_video_grid)
    NoScrollGridView masterVideoGrid;
    @ViewById(R.id.master_users_grid)
    NoScrollGridView masterUsersGrid;

    @ViewById(R.id.album_video_grid)
    NoScrollGridView albumVideoGrid;
    @ViewById(R.id.album_album_grid)
    NoScrollGridView albumAlbumGrid;

    @ViewById(R.id.match_video_grid)
    NoScrollGridView matchVideoGrid;
    @ViewById(R.id.match_users_grid)
    NoScrollGridView matchUsersGrid;

    @ViewById(R.id.other_video_grid)
    NoScrollGridView otherVideoGrid;


    @ViewById(R.id.more_video_grid)
    NoScrollGridView moreVideoGrid;

    @ViewById(R.id.content_home_index_more_view)
    View moreView;

    HomeIndexEntity homeIndexEntity;

    boolean isPull = false;
    int page = 0;
    List<SimpleVideoModel> videos = new ArrayList<SimpleVideoModel>();
    SimpleVideoAdapter simpleVideoAdapter;

    public static HomeIndexFragment newInstance() {
        HomeIndexFragment fragment = new HomeIndexFragment_();
        return fragment;
    }

    @AfterViews
    public void afterViews() {
        mPageName = HomeIndexFragment.class.getName();
        simpleVideoAdapter = new SimpleVideoAdapter(getActivity(), videos);
        moreVideoGrid.setAdapter(simpleVideoAdapter);

        scrollView.setOnRefreshListener(new PullToRefreshBase.OnRefreshListener2<ScrollView>() {
            @Override
            public void onPullDownToRefresh(PullToRefreshBase<ScrollView> refreshView) {
                isPull = true;
                page = 0;
                getData();
            }

            @Override
            public void onPullUpToRefresh(PullToRefreshBase<ScrollView> refreshView) {
                getMore();
                page++;
            }
        });

        getData();

    }


    public void getData() {
        String cacheConfigString = ConfigCache.getUrlCache(QTUrl.home_index_index);
        //根据结果判定是读取缓存，还是重新读取
        if (cacheConfigString != null) {
            try {
                homeIndexEntity = (HomeIndexEntity) JSON.parseObject(cacheConfigString, HomeIndexEntity.class);
                recevieData(homeIndexEntity);
            } catch (Exception e) {
                receiveError();
            }
        }else {
            QTApi.getHomeIndex(new TextHttpResponseHandler() {
                @Override
                public void onSuccess(int status, Header[] headers, String response) {

                    try {
                        homeIndexEntity = (HomeIndexEntity) JSON.parseObject(response, HomeIndexEntity.class);
                        ConfigCache.setUrlCache(response,QTUrl.home_index_index);
                        recevieData(homeIndexEntity);

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
    }

    public void receiveError() {
        netWorkErrorView.setVisibility(View.VISIBLE);
        scrollView.onRefreshComplete();
    }

    @UiThread
    public void recevieData(HomeIndexEntity homeIndexEntity) {

        loadingBar.setVisibility(View.GONE);
        scrollView.onRefreshComplete();
        if (page == 0) {
            moreView.setVisibility(View.GONE);
        }
        bannerAdView.setAdpter(new BannerPagerAdapter(getActivity(), homeIndexEntity.getSlides()));
        hotVideoGrid.setAdapter(new SimpleVideoAdapter(getActivity(), homeIndexEntity.getHotvideos()));
        commVideoGrid.setAdapter(new SimpleVideoAdapter(getActivity(), homeIndexEntity.getCommvideos()));
        commUsersGrid.setAdapter(new SimpleUserAdapter(getActivity(), homeIndexEntity.getCommusers()));

        masterVideoGrid.setAdapter(new SimpleVideoAdapter(getActivity(), homeIndexEntity.getMastervideos()));
        masterUsersGrid.setAdapter(new SimpleUserAdapter(getActivity(), homeIndexEntity.getMasterusers()));

        albumVideoGrid.setAdapter(new SimpleVideoAdapter(getActivity(), homeIndexEntity.getAlbumvideos()));
        albumAlbumGrid.setAdapter(new SimpleAlbumAdapter(getActivity(), homeIndexEntity.getVideoalbums()));

        matchVideoGrid.setAdapter(new SimpleVideoAdapter(getActivity(), homeIndexEntity.getMatchvideos()));
        matchUsersGrid.setAdapter(new SimpleUserAdapter(getActivity(), homeIndexEntity.getMatchusers()));

        otherVideoGrid.setAdapter(new SimpleVideoAdapter(getActivity(), homeIndexEntity.getOthervideos()));
    }

    public void resetMore() {
        videos.clear();
        simpleVideoAdapter.notifyDataSetChanged();
        moreVideoGrid.requestLayout();
    }

    public void receiveMoreError() {
        scrollView.onRefreshComplete();
    }

    @UiThread
    public void recevieMoreData(List<SimpleVideoModel> videoModels) {
        if (videoModels == null) {

            scrollView.onRefreshComplete();
            return;
        }
        scrollView.onRefreshComplete();
        moreView.setVisibility(View.VISIBLE);
        if (page == 0) {
            videos.clear();
        }
        videos.addAll(videoModels);
        simpleVideoAdapter.notifyDataSetChanged();
        moreVideoGrid.requestLayout();
    }


    public void getMore() {
        QTApi.getUrlPage(QTUrl.home_fresh_video, page, new TextHttpResponseHandler() {
            @Override
            public void onSuccess(int i, Header[] headers, String response) {
                try {
                    SimpleVideoListEntity simpleVideoListEntity = (SimpleVideoListEntity) JSON.parseObject(response, SimpleVideoListEntity.class);
                    recevieMoreData(simpleVideoListEntity.getVideos());

                } catch (Exception e) {

                    receiveMoreError();
                }
            }

            @Override
            public void onFailure(int i, Header[] headers, String response, Throwable throwable) {
                receiveMoreError();
            }
        });
    }


    @Override
    public void onResume() {
        super.onResume();
        applyScrollListener();
    }

    private void applyScrollListener() {
        moreVideoGrid.setOnScrollListener(new PauseOnScrollListener(ImageLoader.getInstance(), pauseOnScroll, pauseOnFling));
    }

    @Click(R.id.more_new_video_btn)
    public void moreNew() {
        Intent intent = new Intent(getActivity(), VideoGridActivity_.class);
        intent.putExtra("title", getString(R.string.content_home_index_hot));
        intent.putExtra("url", QTUrl.home_fresh_video);
        startActivity(intent);
    }

    @Click(R.id.more_comm_video_btn)
    public void moreComm() {
        Intent intent = new Intent(getActivity(), VideoGridActivity_.class);
        intent.putExtra("title", getString(R.string.content_home_index_comm));
        intent.putExtra("url", QTUrl.home_comm_video);
        startActivity(intent);
    }

    @Click(R.id.more_comm_user_btn)
    public void moreCommUser() {
        Intent intent = new Intent(getActivity(), UserGridActivity_.class);
        intent.putExtra("title", getString(R.string.content_home_index_comm_user));
        intent.putExtra("url", QTUrl.cate_comm_user);
        startActivity(intent);
    }

    @Click(R.id.more_master_video_btn)
    public void moreMasterVideo() {
        Intent intent = new Intent(getActivity(), VideoGridActivity_.class);
        intent.putExtra("title", getString(R.string.content_home_index_master));
        intent.putExtra("url", QTUrl.home_master_video);
        startActivity(intent);
    }

    @Click(R.id.more_master_user_btn)
    public void moreMasterUser() {
        Intent intent = new Intent(getActivity(), UserGridActivity_.class);
        intent.putExtra("title", getString(R.string.content_home_index_master_user));
        intent.putExtra("url", QTUrl.cate_master_user);
        startActivity(intent);
    }

    @Click(R.id.more_album_video_btn)
    public void moreAlbumVideo() {
        Intent intent = new Intent(getActivity(), VideoGridActivity_.class);
        intent.putExtra("title", getString(R.string.content_home_index_album));
        intent.putExtra("url", QTUrl.home_album_video);
        startActivity(intent);
    }

    @Click(R.id.more_album_album_btn)
    public void moreAlbumAlbum() {
        Intent intent = new Intent(getActivity(), AlbumGridActivity_.class);
        intent.putExtra("title", getString(R.string.content_home_index_album_album));
        startActivity(intent);
    }

    @Click(R.id.more_match_video_btn)
    public void moreMatchVideo() {
        Intent intent = new Intent(getActivity(), VideoGridActivity_.class);
        intent.putExtra("title", getString(R.string.content_home_index_match));
        intent.putExtra("url", QTUrl.home_match_video);
        startActivity(intent);
    }


    @Click(R.id.more_match_user_btn)
    public void moreMatchUser() {
        Intent intent = new Intent(getActivity(), UserGridActivity_.class);
        intent.putExtra("title", getString(R.string.content_home_index_match_user));
        intent.putExtra("url", QTUrl.cate_match_user);
        startActivity(intent);
    }

    @Click(R.id.more_other_video_btn)
    public void moreOtherVideo() {
        Intent intent = new Intent(getActivity(), VideoGridActivity_.class);
        intent.putExtra("title", getString(R.string.content_home_index_other));
        intent.putExtra("url", QTUrl.home_other_video);
        startActivity(intent);
    }
}
