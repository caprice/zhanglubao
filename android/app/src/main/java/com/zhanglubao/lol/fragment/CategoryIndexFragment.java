package com.zhanglubao.lol.fragment;

import android.content.Intent;
import android.view.View;
import android.widget.ScrollView;

import com.alibaba.fastjson.JSON;
import com.loopj.android.http.TextHttpResponseHandler;
import com.zhanglubao.lol.R;
import com.zhanglubao.lol.activity.AlbumGridActivity_;
import com.zhanglubao.lol.activity.HeroGridActivity_;
import com.zhanglubao.lol.activity.UserGridActivity_;
import com.zhanglubao.lol.adapter.SimpleAlbumAdapter;
import com.zhanglubao.lol.adapter.SimpleHeroAdapter;
import com.zhanglubao.lol.adapter.SimpleUserAdapter;
import com.zhanglubao.lol.network.QTApi;
import com.zhanglubao.lol.network.QTUrl;
import com.zhanglubao.lol.network.entity.CategoryIndexEntity;
import com.zhanglubao.lol.view.video.NoScrollGridView;
import com.zhanglubao.pulltorefresh.PullToRefreshBase;
import com.zhanglubao.pulltorefresh.PullToRefreshScrollView;

import org.androidannotations.annotations.AfterViews;
import org.androidannotations.annotations.Click;
import org.androidannotations.annotations.EFragment;
import org.androidannotations.annotations.UiThread;
import org.androidannotations.annotations.ViewById;
import org.apache.http.Header;

/**
 * Created by rocks on 14-12-6.
 */
@EFragment(R.layout.fragment_category_index)
public class CategoryIndexFragment extends BaseFragment {

    @ViewById(R.id.loadingBar)
    View loadingBar;
    @ViewById(R.id.netWorkError)
    View netWorkErrorView;
    @ViewById(R.id.homeScrollView)
    PullToRefreshScrollView scrollView;

    @ViewById(R.id.cate_album_grid)
    NoScrollGridView albumGrid;
    @ViewById(R.id.cate_comm_users_grid)
    NoScrollGridView commGrid;
    @ViewById(R.id.cate_hero_grid)
    NoScrollGridView heroGrid;
    @ViewById(R.id.cate_master_users_grid)
    NoScrollGridView masterGrid;
    @ViewById(R.id.cate_match_users_grid)
    NoScrollGridView matchGrid;
    @ViewById(R.id.cate_pro_users_grid)
    NoScrollGridView proGrid;
    @ViewById(R.id.cate_team_users_grid)
    NoScrollGridView teamGrid;

    boolean isPull = false;

    public static CategoryIndexFragment newInstance() {
        CategoryIndexFragment fragment = new CategoryIndexFragment_();
        return fragment;
    }

    @AfterViews
    public void afterViews() {
        mPageName=CategoryIndexFragment.class.getName();

        scrollView.setOnRefreshListener(new PullToRefreshBase.OnRefreshListener2<ScrollView>() {
            @Override
            public void onPullDownToRefresh(PullToRefreshBase<ScrollView> refreshView) {
                isPull = true;
                getData();
            }

            @Override
            public void onPullUpToRefresh(PullToRefreshBase<ScrollView> refreshView) {

            }
        });

        getData();

    }
    public void getData() {
        if (!isPull) {
            loadingBar.setVisibility(View.VISIBLE);
        }
        QTApi.getCateIndex(new TextHttpResponseHandler() {
            @Override
            public void onSuccess(int status, Header[] headers, String response) {

                try {
                   CategoryIndexEntity categoryIndexEntity = (CategoryIndexEntity) JSON.parseObject(response, CategoryIndexEntity.class);
                    recevieData(categoryIndexEntity);

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
    public void recevieData(CategoryIndexEntity categoryIndexEntity) {

        loadingBar.setVisibility(View.GONE);
        scrollView.onRefreshComplete();
        heroGrid.setAdapter(new SimpleHeroAdapter(getActivity(), categoryIndexEntity.getHeros()));
        commGrid.setAdapter(new SimpleUserAdapter(getActivity(),categoryIndexEntity.getComms()));
        masterGrid.setAdapter(new SimpleUserAdapter(getActivity(),categoryIndexEntity.getMasters()));
        proGrid.setAdapter(new SimpleUserAdapter(getActivity(),categoryIndexEntity.getPros()));
        teamGrid.setAdapter(new SimpleUserAdapter(getActivity(),categoryIndexEntity.getTeams()));
        matchGrid.setAdapter(new SimpleUserAdapter(getActivity(),categoryIndexEntity.getMatches()));
        albumGrid.setAdapter(new SimpleAlbumAdapter(getActivity(),categoryIndexEntity.getAlbums()));
    }

    @Click(R.id.more_hero_btn)
    public  void moreHero()
    {
        Intent intent =new Intent(getActivity(), HeroGridActivity_.class);
        startActivity(intent);
    }
    @Click(R.id.more_comm_user_btn)
    public void moreCommUser() {
        Intent intent=new Intent(getActivity(), UserGridActivity_.class);
        intent.putExtra("title",getString(R.string.content_category_index_comm_user));
        intent.putExtra("url", QTUrl.cate_comm_user);
        startActivity(intent);
    }
    @Click(R.id.more_pro_user_btn)
    public void moreProUser() {
        Intent intent=new Intent(getActivity(), UserGridActivity_.class);
        intent.putExtra("title",getString(R.string.content_category_index_comm_user));
        intent.putExtra("url", QTUrl.cate_pro_user);
        startActivity(intent);
    }
    @Click(R.id.more_team_user_btn)
         public void moreTeamUser() {
        Intent intent=new Intent(getActivity(), UserGridActivity_.class);
        intent.putExtra("title",getString(R.string.content_category_index_pro_user));
        intent.putExtra("url", QTUrl.cate_team_user);
        startActivity(intent);
    }

    @Click(R.id.more_match_user_btn)
    public void moreMatchUser() {
        Intent intent=new Intent(getActivity(), UserGridActivity_.class);
        intent.putExtra("title",getString(R.string.content_category_index_pro_user));
        intent.putExtra("url", QTUrl.cate_match_user);
        startActivity(intent);
    }


    @Click(R.id.more_album_album_btn)
    public void moreAlbumAlbum() {
        Intent intent=new Intent(getActivity(), AlbumGridActivity_.class);
        intent.putExtra("title",getString(R.string.content_home_index_album_album));
        startActivity(intent);
    }
}
