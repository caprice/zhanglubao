package com.zhanglubao.lol.network.entity;

import com.zhanglubao.lol.model.CommentModel;

import java.util.List;

/**
 * Created by rocks on 15-6-25.
 */
public class CommentListEntity {
    List<CommentModel> comments;
    int status;

    public List<CommentModel> getComments() {
        return comments;
    }

    public void setComments(List<CommentModel> comments) {
        this.comments = comments;
    }

    public int getStatus() {
        return status;
    }

    public void setStatus(int status) {
        this.status = status;
    }
}
