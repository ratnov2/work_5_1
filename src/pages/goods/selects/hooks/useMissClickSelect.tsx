import { RefObject, useEffect } from "react";

export const useMissClickSelect = (
  inputRef: RefObject<any>,
  isOpen: boolean,
  setIsOpen: (isOpen: boolean) => void
) => {
  useEffect(() => {
    const handleClickOutside = (e: any) => {
      if (inputRef.current && !inputRef.current.contains(e.target)) {
        setIsOpen(false);
      }
    };

    if (isOpen) {
      document.addEventListener("click", handleClickOutside);
    } else {
      document.removeEventListener("click", handleClickOutside);
    }
    return () => {
      document.removeEventListener("click", handleClickOutside);
    };
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [isOpen]);
};
