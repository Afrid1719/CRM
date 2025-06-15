import { useCallback } from "react";
import { toast } from "react-toastify";

const defaultConfig = {
    type: "info",
    theme: "dark",
    position: "top-right",
    autoClose: 5000,
    hideProgressBar: false,
    closeOnClick: true,
    pauseOnHover: true,
    draggable: false,
    progress: undefined
};

const useAsyncNotifier = () => {
    const notify = useCallback((promise, config = {}) => {
        return toast.promise(
            promise,
            {
                pending: config.pendingMessage || "Processing...",
                success: {
                    render({ data }) {
                        return (
                            config.successMessage ||
                            data.response?.data?.message ||
                            "Successful!"
                        );
                    },
                    icon: "✅"
                },
                error: {
                    render({ data }) {
                        return (
                            config.errorMessage ||
                            data.response?.data?.message ||
                            "An error occurred!"
                        );
                    }
                }
            },
            { ...defaultConfig, ...config }
        );
    }, []);

    return notify;
};

export default useAsyncNotifier;
