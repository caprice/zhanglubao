package com.zhanglubao.lol.network.entity;

import com.zhanglubao.lol.model.CommentModel;
import com.zhanglubao.lol.model.SimpleVideoModel;
import com.zhanglubao.lol.model.VideoModel;

import java.util.List;

/**
 * Created by rocks on 15-6-8.
 */
public class VideoDetailEntity {
    int status;
    VideoModel video;
    List<SimpleVideoModel> relates;
    List<CommentModel> comments;

    public List<SimpleVideoModel> getRelates() {
        return relates;
    }

    public void setRelates(List<SimpleVideoModel> relates) {
        this.relates = relates;
    }

    public int getStatus() {
        return status;
    }

    public void setStatus(int status) {
        this.status = status;
    }

    public VideoModel getVideo() {
        return video;
    }

    public void setVideo(VideoModel video) {
        this.video = video;
    }

    public List<CommentModel> getComments() {
        return comments;
    }

    public void setComments(List<CommentModel> comments) {
        this.comments = comments;
    }
}
