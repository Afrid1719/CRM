import { forwardRef } from "react";
import InputLabel from "./InputLabel";

export default forwardRef(function RadioButton(
    { children, inputClassName = "", textClassName = "", ...props },
    ref
) {
    return (
        <InputLabel className="flex items-center">
            <input
                {...props}
                ref={ref}
                type="radio"
                className={`mr-2 ${inputClassName}`}
            />
            <span className={`capitalize ${textClassName}`}>{children}</span>
        </InputLabel>
    );
});
