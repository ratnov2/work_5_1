import { FC, useState } from "react";
import { Service } from "../../../../api/service";
import { SelectItem } from "../SelectItem";
import { useFilteredItems } from "../useFilteredItems";
import { IWithSelect } from "../type";

export const WithPriceSelect: FC<IWithSelect> = ({ select, setSelect }) => {
  const { isLoading, items, getFilteredItems, isEndPagination, offset } =
    useFilteredItems("price");
  return (
    <SelectItem
      currentValueInSelect={select}
      getInfo={getFilteredItems}
      items={items}
      loadingSelect={isLoading}
      setSelectInfo={setSelect}
      isEndPagination={isEndPagination}
      offset={offset}
      title="Для того, чтобы получить информацию о доступных ценах"
    />
  );
};