import { useState } from "react";
import { Service } from "../../../api/service";
import { TypeFilter } from "../../../type";

export const useFilteredItems = (type: TypeFilter) => {
  const limit = 30;
  const [items, setItems] = useState<string[]>([]);
  const [isEndPagination, setIsEndpagination] = useState(true);
  const [isLoading, setIsLoading] = useState(false);
  const [offset, setOffset] = useState(0);

  const getFilteredItems = (typeClick?: "left" | "right") => {
    let offsetVar = offset;
    if (typeClick === "left" && offset - limit < 0) {
      offsetVar = 0;
      setOffset(0);
    }
    if (typeClick === "right" && !isEndPagination) {
      offsetVar = offset + limit;
      setOffset(offset + limit);
    }
    setIsLoading(true);
    Service.getGoodsByField(type, offsetVar).then((items) => {
      setItems(items.result as string[]);
      setIsEndpagination(items.isEndPagination);
      setIsLoading(false);
    });
  };
  return { items, isLoading, getFilteredItems, isEndPagination, offset };
};
