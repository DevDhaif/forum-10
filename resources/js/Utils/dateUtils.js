import moment from "moment";

export const arabicRelativeTime = (date) => {
    const now = new Date();
    const diffInSeconds = Math.floor((now - new Date(date)) / 1000);
    let interval, unit;

    if (diffInSeconds < 60) {
        unit = "s";
        interval = diffInSeconds;
    } else if (diffInSeconds < 3600) {
        unit = "m";
        interval = Math.floor(diffInSeconds / 60);
    } else if (diffInSeconds < 86400) {
        unit = "h";
        interval = Math.floor(diffInSeconds / 3600);
    } else if (diffInSeconds < 2592000) {
        unit = "d";
        interval = Math.floor(diffInSeconds / 86400);
    } else if (diffInSeconds < 31536000) {
        unit = "M";
        interval = Math.floor(diffInSeconds / 2592000);
    } else {
        unit = "y";
        interval = Math.floor(diffInSeconds / 31536000);
    }

    const arabicUnits = {
        s: interval === 1 ? "ثانية" : interval === 2 ? "ثانيتان" : "ثوان",
        m: interval === 1 ? "دقيقة" : interval === 2 ? "دقيقتان" : "دقائق",
        h: interval === 1 ? "ساعة" : interval === 2 ? "ساعتان" : "ساعات",
        d: interval === 1 ? "يوم" : interval === 2 ? "يومان" : "أيام",
        M: interval === 1 ? "شهر" : interval === 2 ? "شهران" : "أشهر",
        y: interval === 1 ? "سنة" : interval === 2 ? "سنتان" : "سنوات",
    };

    const arabicPluralRules = {
        1: "",
        2: "2",
        default: interval,
    };

    const getArabicNumber = (interval) => {
        if (interval === 1) {
            return "";
        } else if (interval === 2) {
            return "";
        } else {
            return interval.toLocaleString("ar");
        }
    };

    const arabicPastFuture = {
        future: "بعد %s",
        past: "منذ %s",
    };

    const isFuture = diffInSeconds < 0;
    const relativeTimeString =
        getArabicNumber(interval) + " " + arabicUnits[unit];

    return isFuture
        ? arabicPastFuture.future.replace("%s", relativeTimeString)
        : arabicPastFuture.past.replace("%s", relativeTimeString);
};

export const formatRelativeTime = (date, locale) => {
    if (locale === "ar") {
        return arabicRelativeTime(date);
    } else {
        return moment(date).fromNow();
    }
};
