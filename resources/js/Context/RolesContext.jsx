import { createContext, useContext, useEffect, useRef } from "react";

const RolesContext = createContext();

const RolesProvider = ({ children }) => {
    const roles = JSON.parse(localStorage.getItem("roles")) || {};

    return (
        <RolesContext.Provider value={roles}>{children}</RolesContext.Provider>
    );
};

export const useRoles = () => useContext(RolesContext);

export default RolesProvider;
