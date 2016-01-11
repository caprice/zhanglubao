package com.zhanglubao.lol.fragment;

import android.content.Intent;
import android.graphics.Bitmap;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;

import com.nostra13.universalimageloader.core.DisplayImageOptions;
import com.nostra13.universalimageloader.core.ImageLoader;
import com.nostra13.universalimageloader.core.display.RoundedBitmapDisplayer;
import com.zhanglubao.lol.R;
import com.zhanglubao.lol.activity.CacheActivity_;
import com.zhanglubao.lol.activity.FavActivity_;
import com.zhanglubao.lol.activity.VideoGridActivity_;
import com.zhanglubao.lol.config.UserConfig;
import com.zhanglubao.lol.evenbus.LoginSuccessEvent;
import com.zhanglubao.lol.evenbus.LogoutEvent;
import com.zhanglubao.lol.model.SimpleUserModel;
import com.zhanglubao.lol.network.QTUrl;
import com.zhanglubao.lol.view.user.LoginDialog;
import com.umeng.fb.FeedbackAgent;

import org.androidannotations.annotations.AfterViews;
import org.androidannotations.annotations.Click;
import org.androidannotations.annotations.EFragment;
import org.androidannotations.annotations.ViewById;

import de.greenrobot.event.EventBus;

/**
 * Created by rocks on 14-11-24.
 */
@EFragment(R.layout.fragment_profile)
public class ProfileFragment extends BaseFragment {

    private DisplayImageOptions useroptions;

    @ViewById(R.id.user_icon)
    ImageView avatarImageView;
    @ViewById(R.id.user_name)
    TextView userNameTextView;
    @ViewById(R.id.not_login_area)
    View noUserArea;
    SimpleUserModel user;

    @AfterViews
    public void afterView() {
        mPageName = ProfileFragment.class.getName();
        if (!EventBus.getDefault().isRegistered(this)) {
            EventBus.getDefault().register(this);
        }
        useroptions = new DisplayImageOptions.Builder()
                .showImageOnLoading(R.drawable.profile_default_face)
                .showImageForEmptyUri(R.drawable.profile_default_face)
                .showImageOnFail(R.drawable.profile_default_face)
                .displayer(new RoundedBitmapDisplayer(100))
                .cacheInMemory(true)
                .cacheOnDisk(true)
                .considerExifParams(true)
                .bitmapConfig(Bitmap.Config.RGB_565)
                .build();
        getUserInfo();
    }

    private void getUserInfo() {
        user = UserConfig.getUser();
        if (user == null) {
            return;
        }

        noUserArea.setVisibility(View.GONE);
        userNameTextView.setVisibility(View.VISIBLE);
        userNameTextView.setText(user.getNickname());
        ImageLoader.getInstance().displayImage(user.getAvatar(),
                avatarImageView, useroptions);
    }


    @Click(R.id.user_head)
    public void showLogin() {
        if (user == null) {
            LoginDialog loginDialog = new LoginDialog(getActivity());
            loginDialog.show();
        } else {
            EventBus.getDefault().post(new LogoutEvent());
        }
    }

    @Click(R.id.feed_back)
    public void feedBack() {
        FeedbackAgent agent = new FeedbackAgent(getActivity());
        agent.startFeedbackActivity();
    }

    @Override
    public void onDestroy() {
        super.onDestroy();
        EventBus.getDefault().unregister(this);
    }

    public void onEvent(LoginSuccessEvent event) {
        user = event.getUser();
        noUserArea.setVisibility(View.GONE);
        userNameTextView.setVisibility(View.VISIBLE);
        userNameTextView.setText(user.getNickname());
        ImageLoader.getInstance().displayImage(user.getAvatar(),
                avatarImageView, useroptions);
    }

    public void onEvent(LogoutEvent event) {
        user = null;
        noUserArea.setVisibility(View.VISIBLE);
        userNameTextView.setVisibility(View.GONE);
        userNameTextView.setText("");
        avatarImageView.setImageResource(R.drawable.profile_default_face);

    }

    @Click(R.id.subscribe_btn)
    public void subscribe() {
        Intent intent = new Intent(getActivity(), VideoGridActivity_.class);
        intent.putExtra("url", QTUrl.user_subscribe_video);
        intent.putExtra("title", getActivity().getResources().getString(R.string.profile_subscribe));
        startActivity(intent);
    }

    @Click(R.id.cache_btn)
    public void cache() {
        Intent intent = new Intent(getActivity(), CacheActivity_.class);
        startActivity(intent);
    }

    @Click(R.id.fav_btn)
    public void fav() {
        Intent intent = new Intent(getActivity(), FavActivity_.class);
        startActivity(intent);
    }

}
