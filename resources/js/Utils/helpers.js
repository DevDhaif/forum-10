import moment from "moment";
export function getFavoritedType(favoritedType) {
    let type = '';
    switch (favoritedType) {
        case 'App\\Models\\Thread':
            type = 'thread';
            break;
        case 'App\\Models\\Reply':
            type = 'reply';
            break;
        case 'App\\Models\\Favorite':
            type = 'favorite';
            break;
        default:
            type = '';
    }
    return type;
}



export function formatDate(dateString) {
    return moment(dateString).fromNow();
}

export function getPath(favorited, type) {
    let path = '';
    switch (type) {
        case 'thread':
            path = `/threads/${favorited.channel.slug}/${favorited.id}`;
            break;
        case 'reply':
            path = `/threads/${favorited.thread.channel.slug}/${favorited.thread.id}#reply-${favorited.id}`;
            break;
        case 'favorite':
            path = `/threads/${favorited.thread.channel.slug}/${favorited.thread.id}#reply-${favorited.reply.id}`;
            break;
        default:
            path = 'no path';
    }
    return path;
}
