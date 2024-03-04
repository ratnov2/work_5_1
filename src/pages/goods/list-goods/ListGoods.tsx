import { FC } from "react";
import { IListGoods } from "./interface";
import style from "./ListGoods.module.css";

export const ListGoods: FC<IListGoods> = ({ goods }) => {
  return (
    <>
      {goods.map((item, key) => (
        <article className={style.goods} key={key}>
          <h2>{item.product}</h2>
          <h2>{item.brand || "No Brand"}</h2>
          <h2>{item.price}</h2>
          <h2>{item.id}</h2>
        </article>
      ))}
    </>
  );
};
