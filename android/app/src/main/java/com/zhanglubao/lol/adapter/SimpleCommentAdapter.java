package com.zhanglubao.lol.adapter;

import android.content.Context;
import android.graphics.Bitmap;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import com.nostra13.universalimageloader.core.DisplayImageOptions;
import com.nostra13.universalimageloader.core.ImageLoader;
import com.nostra13.universalimageloader.core.display.RoundedBitmapDisplayer;
import com.zhanglubao.lol.R;
import com.zhanglubao.lol.model.CommentModel;

import java.util.List;

/**
 * Created by rocks on 15-6-22.
 */
public class SimpleCommentAdapter extends BaseAdapter {
    List<CommentModel> comments;
    Context context;
    private LayoutInflater inflater;
    private DisplayImageOptions options;

    public SimpleCommentAdapter(List<CommentModel> comments, Context context) {
        this.comments = comments;
        this.context = context;
        inflater = LayoutInflater.from(context);
        options = new DisplayImageOptions.Builder()
                .showImageOnLoading(R.drawable.default_user_avatar)
                .showImageForEmptyUri(R.drawable.default_user_avatar)
                .showImageOnFail(R.drawable.default_user_avatar)
                .displayer(new RoundedBitmapDisplayer(100))
                .cacheInMemory(true)
                .cacheOnDisk(true)
                .considerExifParams(true)
                .bitmapConfig(Bitmap.Config.RGB_565)
                .build();
    }

    @Override
    public int getCount() {
        return comments.size();
    }

    @Override
    public Object getItem(int position) {
        return comments.get(position);
    }

    @Override
    public long getItemId(int position) {
        return position;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {

        CommentModel commentModel = comments.get(position);
        View view = convertView;
        final ViewHolder holder;
        if (view == null) {
            view = inflater.inflate(R.layout.view_comment_view, parent, false);
            holder = new ViewHolder();
            holder.avatarImageView = (ImageView) view.findViewById(R.id.user_img);
            holder.nicknameTextView = (TextView) view.findViewById(R.id.comment_name);
            holder.contentTextView = (TextView) view.findViewById(R.id.comment_content);
            view.setTag(holder);
        } else {
            holder = (ViewHolder) view.getTag();
        }
        if (commentModel.getUser()!=null) {
            ImageLoader.getInstance().displayImage(commentModel.getUser().getAvatar(), holder.avatarImageView, options);
            holder.nicknameTextView.setText(commentModel.getUser().getNickname());
        }
        holder.contentTextView.setText(commentModel.getContent());

        return view;
    }


    static class ViewHolder {
        ImageView avatarImageView;
        TextView nicknameTextView;
        TextView contentTextView;
    }
}
