import { useState } from "react";
import { Service } from "../../../../api/service";
import { TypeFilter } from "../../../../type";

export const useFilteredItems = (type: TypeFilter) => {
  const [items, setItems] = useState<string[]>([]);
  const [isLoading, setIsLoading] = useState(false);

  const getFilteredItems = async () => {
    setIsLoading(true);
    const response = await Service.getGoodsByField(type);
    setItems(response);
    setIsLoading(false);
  };
  return { items, isLoading, getFilteredItems };
};
