"use strict";

import { combineReducers } from "redux";
import { thingReducer } from "./ThingReducer";
import { stuffReducer } from "./StuffReducer";

const Reducers = combineReducers({
  thingReducer,
  stuffReducer
});

export default Reducers;
