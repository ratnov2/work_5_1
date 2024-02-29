import { FC, useEffect, useState } from "react";
import { Service } from "../../../api/service";
import Paginator from "../paginator/Paginator";
import { TGoods } from "../../../type";
import { TTypeGoods } from "../Googs";

interface IGoodsPage {
  //goods: string[] | null;
  onSetGoods: (ids: TGoods[]) => void;
  onSetGoodsIds: (ids: string[]) => void;
  listIds: string[] | null;
  typeGoods: TTypeGoods;
  onSetTypeGoods: (type: TTypeGoods) => void;
}

export const GoodsPage: FC<IGoodsPage> = ({
  onSetGoods,
  onSetGoodsIds,
  listIds,
  onSetTypeGoods,
  typeGoods,
}) => {
  const [isFirstRequest, setIsFirestRequest] = useState(true);
  const [currentLimit, setCurrentLimit] = useState(40);
  const [currentOffset, setCurrentOffset] = useState(0);

  const handleReqIsFirst = async () => {
    if (isFirstRequest) {
      const listIds = await Service.getGoods();
      onSetGoodsIds(listIds.result);
      const listLimitedIds = listIds.result.slice(
        currentOffset,
        currentOffset + currentLimit
      );
      setIsFirestRequest(false);
      const goods = await Service.getItems(listLimitedIds);
      onSetGoods(goods.result);
    } else {
      const listLimitedIds = listIds
        ? listIds.slice(currentOffset, currentOffset + currentLimit)
        : [];
      const goods = await Service.getItems(listLimitedIds);
      onSetGoods(goods.result);
    }
    typeGoods !== "goods" && onSetTypeGoods("goods");
  };

  return (
    <div>
      <button onClick={() => handleReqIsFirst()}>Получить товары</button>
    </div>
  );
};
