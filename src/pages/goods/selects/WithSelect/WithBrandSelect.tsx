import { FC } from "react";
import { SelectItem } from "../SelectItem";
import { IWithSelect } from "../type";
import { useFilteredItems } from "../useFilteredItems";

export const WithBrandSelect: FC<IWithSelect> = ({ select, setSelect }) => {
  const { isLoading, items, getFilteredItems, isEndPagination, offset } =
    useFilteredItems("brand");
  return (
    <SelectItem
      currentValueInSelect={select}
      getInfo={getFilteredItems}
      items={items}
      loadingSelect={isLoading}
      setSelectInfo={setSelect}
      isEndPagination={isEndPagination}
      offset={offset}
      title="Для того, чтобы получить информацию о доступных брендах"
    />
  );
};
