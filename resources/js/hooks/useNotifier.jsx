import { useCallback } from "react";
import { toast } from "react-toastify";

const defaultConfig = {
    type: 'info',
    theme: 'dark',
    position: "top-right",
    autoClose: 5000,
    hideProgressBar: false,
    closeOnClick: true,
    pauseOnHover: true,
    draggable: false,
    progress: undefined,

};

const useNotifier = () => {
    const notify = useCallback((message, config = {}) => {
        toast(message, {
            ...defaultConfig,
            ...config
        });
    }, []);

    return notify;
};

export default useNotifier