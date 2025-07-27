import { createContext, useContext, useCallback } from "react";

const RolesContext = createContext();

const RolesProvider = ({ children }) => {
    const roles = JSON.parse(localStorage.getItem("roles")) || {};
    const isAdmin = useCallback((role) => role === 0, [roles]);
    const isUser = useCallback((role) => role === 1, [roles]);
    const isGuest = useCallback((role) => role === 2, [roles]);

    return (
        <RolesContext.Provider value={{ roles, isAdmin, isUser, isGuest }}>
            {children}
        </RolesContext.Provider>
    );
};

export const useRoles = () => useContext(RolesContext);

export default RolesProvider;
